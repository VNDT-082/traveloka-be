<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\MemberBookHotel_Model;
use App\Services\BookingHotel\IBookingHotelService;
use App\Services\Guest\IGuestService;
use App\Services\MemberBookHotel\IMemberBookHotelService;
use App\Services\Room\IRoomService;
use App\Services\SendMail\ISendMailService;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\BookingConfirmation;
use App\Mail\BookingCancellation;

use App\Models\BookingHotel_Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Laravel\Prompts\select;

class BookingHotel_Controller extends Controller
{
    protected $IBookingHotelService;
    protected $IMemberBookHotelService;
    protected $IRoomService;
    protected $ISendMailService;
    protected $IGuestService;
    public function __construct(
        IBookingHotelService $IBookingHotelService,
        IMemberBookHotelService $IMemberBookHotelService,
        IRoomService $IRoomService,
        ISendMailService $ISendMailService,
        IGuestService $IGuestService
    ) {
        $this->IBookingHotelService = $IBookingHotelService;
        $this->IMemberBookHotelService = $IMemberBookHotelService;
        $this->IRoomService = $IRoomService;
        $this->ISendMailService = $ISendMailService;
        $this->IGuestService = $IGuestService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getListByUserId(Request $request)
    {
        if ($request->query('id')) {
            $id = $request->query('id');
            $response = $this->IBookingHotelService->getListByUserId($id);
            return $response ? ['status' => 200, 'result' => $response]
                : ['status' => 200, 'result' => 'NOT_FOUND'];
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData =  $request->validate([
                'id' => 'required',
                'GuestId' => 'required',
                'RoomId' => 'required',
                'ConfirmBy' => 'nullable',
                //'CreateDate' => 'required',
                'Price' => 'required',
                'Gift' => 'nullable',
                'Discount' => 'nullable',
                'State' => 'required',
                'Notes' => 'nullable',
                'TypePay' => 'required',
                'TimeRecive' => 'required',
                'TimeLeave' => 'required',
                'ConfirmAt' => 'nullable',
                'created_at' => 'required',
                'updated_at' => 'required',
            ]);
            $validatedCreateDate =  $request->validate(['CreateDate' => 'required']);
            $datetime = new DateTime($validatedCreateDate['CreateDate']);
            $validatedData['CreateDate'] = $datetime->format('Y-m-d H:i:s');

            if (isset($validatedData['ConfirmAt'])) {
                $conformAt = new DateTime($validatedData['ConfirmAt']);
                $validatedData['ConfirmAt'] = $conformAt->format('Y-m-d H:i:s');
            }

            $validatedData['State'] = $validatedData['State'] ? 1 : 0;
            // $validatedDataMember = $request->validate(['members' => 'nullable']);
            // ---------------------------------------------


            DB::beginTransaction();

            $validatedTotalRoom = $request->validate(['totalRoom' => 'required']);
            $note = '';

            if ($validatedTotalRoom['totalRoom'] > 1) {
                $total = $validatedTotalRoom['totalRoom'] - 1;
                $sql = "SELECT room.id from room WHERE room.State=0 and room.TypeRoomId=
(SELECT room.TypeRoomId FROM room where room.id='" . $validatedData['RoomId'] . "')
AND room.id<> '" . $validatedData['RoomId'] . "' LIMIT 0," . $total . "";


                $data = DB::select($sql);

                if ($data && count($data) >= $validatedTotalRoom['totalRoom'] - 1) {
                    foreach ($data as $dataItem) {
                        $note = $note . $dataItem->id . ";";
                        $sql = "UPDATE room SET room.TimeRecive='" . $validatedData['TimeRecive']
                            . "', room.TimeLeave='" . $validatedData['TimeLeave'] . "',State=1 WHERE room.id='" . $dataItem->id . "'";
                    }
                    $validatedData['Notes'] = $note;
                }
            }



            $result = $this->IBookingHotelService->create($validatedData);
            // if ($result) {
            //     if (isset($validatedDataMember['members'])) {
            //         if (count($validatedDataMember['members']) > 0) {
            //             for ($i = 0; $i < count($validatedDataMember['members']); $i++) {
            //                 $member = $validatedDataMember['members'][$i];
            //                 if (isset($member['DateOfBirth'])) {
            //                     $DateOfBirth = new DateTime($member['DateOfBirth']);
            //                     $member['DateOfBirth'] = $DateOfBirth->format('Y-m-d');
            //                 }
            //                 $memberData = [
            //                     'id' => $member['id'],
            //                     'BookHotelId' =>  $result['id'],
            //                     'DateOfBirth' => $member['DateOfBirth'],
            //                     'FullName' => $member['FullName'],
            //                     'Sex' => $member['Sex'] ? 1 : 0,
            //                     'created_at' => $member['created_at'],
            //                     'updated_at' => $member['updated_at']
            //                 ];
            //                 $result_member = $this->IMemberBookHotelService->create($memberData);
            //             }
            //         }
            //     }
            // }
            $result_updateStateRoom = $this->IRoomService->updateStateRoom($result['RoomId'], true);

            $room = $this->IRoomService->getOneById($result['RoomId']);
            $guest = $this->IGuestService->getOneById($result['GuestId']);

            $result_sendMail = $this->ISendMailService->sendMailNotifyToBuyer(
                $result,
                $guest['Name'],
                $room['typeroom']['Name'],
                $room['typeroom']['hotel']['Name'],
                $guest['Email']
            );
            $sendMailMessage = 'Gửi mail không thành công';
            if ($result_sendMail) {
                $sendMailMessage = 'Gửi mail thành công';
            }

            DB::commit();
            return response()->json([
                'message' => "Đã đặt phòng thành công thành công - " . $sendMailMessage,
                'status' => 'successfully',
                'result' => $validatedData
            ], 200);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                'message' => "Đặt phòng thất bại, vui lòng thử lại.",
                'status' => 'error',
                'data' => $validatedData,
                'result' => $ex
            ], 400);
        }
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
                'b.cancellation_reason as cancel_reason',
                'b.TypePay as payment',
                'b.VAT as VAT',
                'GiftCodePrice as code_price',
                'b.GiftCode as gift',
                'b.Notes as note',
                'b.State as booking_status',
                'mb.member_count',
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
                'b.cancellation_reason',
                'b.TypePay',
                'b.VAT',
                'GiftCodePrice',
                'b.GiftCode',
                'b.Notes',
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

    public function getCustomerToday(Request $request)
    {
        $today = Carbon::now();
        $hotelId = $request->input('idHotel');

        $bookings = DB::table('bookinghotel')
            ->join('guest', 'bookinghotel.GuestId', '=', 'guest.id')
            ->join('room', 'bookinghotel.RoomId', '=', 'room.id')
            ->join('typeroom', 'room.TypeRoomId', '=', 'typeroom.id')
            ->join('memberbookhotel', 'bookinghotel.id', '=', 'memberbookhotel.BookHotelId')
            ->select(
                'guest.Name as guest_name',
                'guest.Telephone as guest_telephone',
                'guest.CCCD as guest_cccd',
                'guest.Sex as guest_sex',
                'memberbookhotel.FullName as member_name',
                'memberbookhotel.DateOfBirth as member_dob',
                'memberbookhotel.Sex as member_sex',
                'room.RoomName as room_name',
                'typeroom.Name as type_name',
                'bookinghotel.TimeRecive as check_in_date',
                'bookinghotel.TimeLeave as check_out_date',
                'typeroom.HotelId as hotel_id',
                'bookinghotel.id as booking_id'
            )
            ->where('bookinghotel.TimeRecive', '<=', $today->format('Y-m-d H:i:s'))
            ->where('bookinghotel.TimeLeave', '>=', $today->format('Y-m-d H:i:s'))
            ->where('typeroom.HotelId', '=', $hotelId)
            ->get();

        $groupedBookings = [];
        foreach ($bookings as $booking) {
            if (!isset($groupedBookings[$booking->booking_id])) {
                $groupedBookings[$booking->booking_id] = [
                    'booking_id' => $booking->booking_id,
                    'guest_name' => $booking->guest_name,
                    'guest_telephone' => $booking->guest_telephone,
                    'guest_cccd' => $booking->guest_cccd,
                    'guest_sex' => $booking->guest_sex,
                    'room_name' => $booking->room_name,
                    'type_name' => $booking->type_name,
                    'check_in_date' => $booking->check_in_date,
                    'check_out_date' => $booking->check_out_date,
                    'members' => []
                ];
            }

            $groupedBookings[$booking->booking_id]['members'][] = [
                'member_name' => $booking->member_name,
                'member_dob' => $booking->member_dob,
                'member_sex' => $booking->member_sex
            ];
        }

        return response()->json(array_values($groupedBookings), 200);
    }

    public function getFrequentGuests(Request $request)
    {
        $idhotel = $request->input('idHotel');

        $guests = DB::table('bookinghotel')
            ->join('guest', 'bookinghotel.GuestId', '=', 'guest.id')
            ->join('room', 'bookinghotel.RoomId', '=', 'room.id')
            ->join('typeroom', 'room.TypeRoomId', '=', 'typeroom.id')
            ->where('typeroom.HotelId', '=', $idhotel)
            ->select('guest.id', 'guest.Name as guest_name', 'guest.Email as guest_email', 'guest.Telephone as guest_telephone')
            ->selectRaw('COUNT(bookinghotel.GuestId) as booking_count')
            ->groupBy('guest.id', 'guest.Name', 'guest.Email', 'guest.Telephone')
            ->having('booking_count', '>', 3)
            ->get();

        return response()->json($guests, 200);
    }
}
