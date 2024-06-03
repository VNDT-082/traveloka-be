<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmation;
use App\Mail\BookingCancellation;

use App\Models\BookingHotel_Model;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BookingHotel_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getBookingsByHotelId(Request $request)
    {

        $hotelId = $request->input('hotelId');

        // Subquery để tính số lượng thành viên cho mỗi booking
        $subqueryMemberBooking = DB::table('memberbookhotel')
            ->select('BookHotelId', DB::raw('COUNT(id) as member_count'))
            ->groupBy('BookHotelId');

        // Truy vấn chính
        $query = DB::table('bookinghotel AS b')
            ->join('room AS r', 'b.RoomId', '=', 'r.id')
            ->join('typeroom AS t', 'r.TyperoomId', '=', 't.id')
            ->join('guest AS g', 'b.GuestId', '=', 'g.id')
            ->leftJoinSub($subqueryMemberBooking, 'mb', function ($join) {
                $join->on('b.id', '=', 'mb.BookHotelId');
            })
            ->select([
                'b.id AS booking_id',
                'b.Price AS booking_price',
                'g.Name AS guest_name',
                'g.Telephone AS guest_phone',
                't.Name AS room_type',
                'r.id AS room_id',
                'r.RoomName AS room_name',
                'b.TimeRecive AS check_in_date',
                'b.TimeLeave AS check_out_date',
                'b.CreateDate AS created_at',
                DB::raw('CASE 
            WHEN b.State = 0 THEN "Chờ xác nhận" 
            WHEN b.State = 1 THEN "Đã xác nhận" 
            WHEN b.State = 2 THEN "Đang ở" 
            WHEN b.State = 3 THEN "Checked out"
            WHEN b.State = 4 THEN "Yêu cầu hủy" 
            WHEN b.State = 5 THEN "Đã hủy" 
            ELSE "Đã thanh toán"
            END AS booking_status '),
                'mb.member_count', // Di chuyển 'member_count' xuống đây
            ])
            ->where('t.HotelId', '=', $hotelId)
            ->groupBy(
                'b.id',
                'g.Name',
                'g.Telephone',
                't.Name',
                'r.id',
                'r.RoomName',
                'b.TimeRecive',
                'b.TimeLeave',
                'b.State',
                'b.CreateDate',
                'b.Price',
                'mb.member_count' // Thêm 'mb.member_count' vào danh sách nhóm
            )
            ->get();

        $bookingIds = $query->pluck('booking_id');

        $memberData = DB::table('memberbookhotel')
            ->select('BookHotelId', 'FullName', 'DateOfBirth', 'Sex')
            ->whereIn('BookHotelId', $bookingIds)
            ->get()
            ->groupBy('BookHotelId');

        // Gắn kết dữ liệu thành viên vào kết quả truy vấn chính
        foreach ($query as &$booking) {
            $booking->members = isset($memberData[$booking->booking_id])
                ? $memberData[$booking->booking_id] // Truy cập member_count như một thuộc tính
                : []; // Trả về một mảng trống nếu không có thành viên nào
        }


        if (empty($query)) {
            return response()->json([
                'message' => 'Không tìm thấy thông tin đặt phòng với ID ' . $hotelId,
            ], 404);
        }

        return response()->json($query, 200);
    }

    public function createBooking(Request $request)
    {
        Log::info('createBooking method called.');




        $currentDateTime = date("YmdHis") . substr((string)microtime(true), 2, 6);
        $randomId = "BK" . $currentDateTime . rand(0, 9999);

        Log::info('Random Booking ID generated.', ['booking_id' => $randomId]);

        $bookingId = DB::table('bookinghotel')->insert([
            'id' => $randomId,
            'RoomId' => $request['room_id'],
            'GuestId' => $request['guest_id'],
            'TimeRecive' => $request['time_recive'],
            'TimeLeave' => $request['time_leave'],
            'State' => $request['state'],
            'Price' => $request['price'],
            'CreateDate' => now(),
            'created_at' => now()
        ]);



        Log::info('Booking created successfully.', ['booking_id' => $bookingId]);

        foreach ($request['members'] as $member) {
            $randomIdMember = "MB" . date("YmdHis") . substr((string)microtime(true), 2, 6) . rand(0, 9999);
            $inserted = DB::table('memberbookhotel')->insert([
                'id' => $randomIdMember,
                'BookHotelId' => $randomId,
                'FullName' => $member['name']
            ]);


            Log::info('Member inserted successfully.', ['member_id' => $randomIdMember]);
        }

        DB::commit();

        Log::info('Transaction committed successfully.');

        return response()->json(['message' => 'Booking created successfully'], 201);
    }


    public function updateState(Request $request)
    {
        $booking = DB::table('bookinghotel')->where('id', $request->id_booking)->first();

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $user_confirm = DB::table('staff')->where('UserAccountId', $request->confirm_by)->first();

        DB::table('bookinghotel')
            ->where('id', $request->id_booking)
            ->update([
                'State' => $request->input('status'),
                'ConfirmBy' => $user_confirm->id,
                'updated_at' => Carbon::now(),
                'ConfirmAt' => Carbon::now(),
            ]);

        $guest = DB::table('guest')->where('id', $booking->GuestId)->first();

        if (!$guest) {
            return response()->json(['error' => 'Guest not found'], 404);
        }

        $room = DB::table('room')->where('id', $booking->RoomId)->first();
        if (!$room) {
            return response()->json(['error' => 'Room not found'], 404);
        }

        $typeroom = DB::table('typeroom')->where('id', $room->TypeRoomId)->first();
        if (!$typeroom) {
            return response()->json(['error' => 'Type room not found'], 404);
        }

        $hotel = DB::table('hotel')->where('id', $typeroom->HotelId)->first();
        if (!$hotel) {
            return response()->json(['error' => 'Hotel not found'], 404);
        }

        $bookingDetails = [
            'booking' => $booking,
            'guest' => $guest,
            'room' => $room,
            'typeroom' => $typeroom,
            'hotel' => $hotel,
        ];

        Mail::to($guest->Email)->send(new BookingConfirmation($bookingDetails));

        return response()->json([
            'message' => 'Booking state updated successfully',
            'id_booking' => $request->id_booking,
            'status' => $request->status
        ], 200);
    }

    public function cancelBooking(Request $request)
    {


        $bookingId = $request->input('booking_id');

        DB::beginTransaction();

        try {
            $roomId = DB::table('bookinghotel')->select('RoomId')->where('id', $bookingId);;
            DB::table('bookinghotel')
                ->where('id', $bookingId)
                ->update([
                    'State' => 6,
                    'updated_at' => Carbon::now()
                ]);

            DB::table('room')
                ->where('id', $roomId)
                ->update([
                    'State' => 0,
                    'updated_at' => Carbon::now()
                ]);

            DB::commit();

            $booking = DB::table('bookinghotel AS b')
                ->join('guest AS g', 'b.GuestId', '=', 'g.id')
                ->join('room AS r', 'b.RoomId', '=', 'r.id')
                ->join('typeroom AS tr', 'r.TypeRoomId', '=', 'tr.id')
                ->join('hotel AS h', 'tr.HotelId', '=', 'h.id')
                ->select([
                    'g.email',
                    'g.Name as guest_name',
                    'b.*',
                    'h.Name as hotel_name',
                    'r.RoomName as room_name',
                    'tr.Name as typeroom_name'
                ])
                ->where('b.id', $bookingId)
                ->first();

            $bookingDetails = [
                'booking' => $booking,
            ];


            if ($booking) {
                Mail::to($booking->email)->send(new BookingCancellation($bookingDetails));
            }

            return response()->json([
                'message' => 'Booking canceled successfully',
                'booking_id' => $bookingId
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'An error occurred while canceling the booking',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
