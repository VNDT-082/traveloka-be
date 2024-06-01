<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\BookingConfirmation;
use App\Models\BookingHotel_Model;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
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
            WHEN b.State = 3 THEN "Đang ở" 
            WHEN b.State = 4 THEN "Checked out"
            WHEN b.State = 5 THEN "Yêu cầu hủy" 
            WHEN b.State = 6 THEN "Đã hủy" 
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
}
