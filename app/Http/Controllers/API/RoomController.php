<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Room\IRoomService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class RoomController extends Controller
{
    protected $IRoomService;
    public function __construct(IRoomService $IRoomService)
    {
        $this->IRoomService = $IRoomService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    //Lay top 10 records dau tien
    public function paginate(Request $request)
    {
    }

    public function getListByTypeRoomID(Request $request)
    {
        if ($request->query('typeRoomID')) {
            $typeRoomID = $request->query('typeRoomID');
            if ($this->IRoomService->getListByTypeRoomID($typeRoomID)->count() > 0)
                return [
                    'result' => $this->IRoomService->getListByTypeRoomID($typeRoomID),
                    'total' => $this->IRoomService->count()
                ];
        }
        return [
            'result' => null,
            'total' => 0
        ];
    }
    public function getOneById(Request $request)
    {
        if ($request->query('id')) {
            $id = $request->query('id');
            $response = $this->IRoomService->getOneById($id);
            return $response ? ['status' => 200, 'result' => $response]
                : ['status' => 200, 'result' => 'NOT_FOUND'];
        }
        return ['status' => 404, 'result' => 'NOT_FOUND'];
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

    public function insertRoom(Request $request)
    {
        try {
            $currentDateTime = date("YmdHis") . substr((string)microtime(true), 2, 6);
            $randomIdRoom = "RO" . $currentDateTime . rand(0, 9999);
            $id = $randomIdRoom;
            $TypeRoomId = $request->TypeRoomId;
            $State = (empty($request->State)) ? 0 :  $request->State;
            $TimeRecive = (empty($request->TimeRecive)) ? null :  $request->TimeRecive;
            $TimeLeave = (empty($request->TimeLeave)) ? null :  $request->TimeLeave;
            $Gift = (empty($request->Gift)) ? 0 :  $request->Gift;
            $Discount = (empty($request->Discount)) ? 0 :  $request->Discount;
            $Breakfast = (empty($request->Breakfast)) ? 0 :  $request->Breakfast;
            $Wifi = (empty($request->Wifi)) ? 0 :  $request->Wifi;
            $NoSmoking = (empty($request->NoSmoking)) ? 0 :  $request->NoSmoking;
            $Cancel = (empty($request->Cancel)) ? 0 :  $request->Cancel;
            $ChangeTimeRecive = (empty($request->ChangeTimeRecive)) ? 0 :  $request->ChangeTimeRecive;
            $RoomName = (empty($request->RoomName)) ? 0 :  $request->RoomName;
            $Hinh_Thuc_Thanh_Toan = (empty($request->Hinh_Thuc_Thanh_Toan)) ? 0 :  $request->Hinh_Thuc_Thanh_Toan;
            $Bao_Gom_Thue_Va_Phi = (empty($request->Bao_Gom_Thue_Va_Phi)) ? 0 :  $request->Bao_Gom_Thue_Va_Phi;
            $createAt =  date("YmdHis");
            $sql = "INSERT INTO room(id, TypeRoomId, State, TimeRecive, TimeLeave, Gift, Discount, Breakfast, Wifi, NoSmoking, Cancel, ChangeTimeRecive, RoomName, Hinh_Thuc_Thanh_Toan, Bao_Gom_Thue_Va_Phi, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?)";

            DB::insert($sql, [
                $id,
                $TypeRoomId,
                $State,
                $TimeRecive,
                $TimeLeave,
                $Gift,
                $Discount,
                $Breakfast,
                $Wifi,
                $NoSmoking,
                $Cancel,
                $ChangeTimeRecive,
                $RoomName,
                $Hinh_Thuc_Thanh_Toan,
                $Bao_Gom_Thue_Va_Phi,
                $createAt,
            ]);
            return response()->json([
                'id' => $id,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }

    public function selectRoom(Request $request)
    {
        $id_hotel = $request->id;

        // Truy vấn chính: lấy dữ liệu phòng, loại phòng và khách sạn
        $data = DB::table('room')
            ->select([
                'room.*',
                'typeroom.Name AS type_name',
                'typeroom.Price AS type_price',
                'hotel.Name AS hotel_name'
            ])
            ->join('typeroom', 'room.TyperoomId', '=', 'typeroom.id')
            ->join('hotel', 'typeroom.HotelId', '=', 'hotel.id')
            ->where('hotel.id', $id_hotel)
            ->get();



        $roomIds = $data->pluck('id')->toArray();

        $bookingData = DB::table('bookinghotel')
            ->whereIn('RoomId', $roomIds)
            ->get()
            ->groupBy('RoomId');

        foreach ($data as $room) {
            $room->booking = isset($bookingData[$room->id]) ? $bookingData[$room->id] : [];
        }

        $bookHotelIds = $bookingData->flatMap(function ($bookings) {
            return $bookings->pluck('id');
        })->toArray();


        $memberBookingData = DB::table('memberbookhotel')
            ->whereIn('BookHotelId', $bookHotelIds)
            ->get()
            ->groupBy('BookHotelId');

        foreach ($data as $room) {
            if (isset($bookingData[$room->id])) {
                foreach ($bookingData[$room->id] as $booking) {
                    $booking->members = isset($memberBookingData[$booking->id])
                        ? $memberBookingData[$booking->id]
                        : [];
                }
                $room->booking = $bookingData[$room->id];
            } else {
                $room->booking = [];
            }
        }


        return response()->json($data, 200);
    }




    public function updateRoom(Request $request)
    {
        try {
            $currentDateTime = date("YmdHis");

            $id = $request->id;
            $TypeRoomId = $request->TypeRoomId;
            $State = $request->State;
            $TimeRecive = (empty($request->TimeRecive)) ? null :  $request->TimeRecive;
            $TimeLeave = (empty($request->TimeLeave)) ? null :  $request->TimeLeave;
            $Gift = $request->Gift;
            $Discount = $request->Discount;
            $Breakfast = $request->Breakfast;
            $Wifi = $request->Wifi;
            $NoSmoking = $request->NoSmoking;
            $Cancel = $request->Cancel;
            $ChangeTimeRecive = (empty($request->ChangeTimeRecive)) ? 0 :  $request->ChangeTimeRecive;
            $updated_at = date("YmdHis");
            $Hinh_Thuc_Thanh_Toan = $request->Hinh_Thuc_Thanh_Toan;
            $RoomName = $request->RoomName;
            $Bao_Gom_Thue_Va_Phi = $request->Bao_Gom_Thue_Va_Phi;

            $sql = "UPDATE room SET 
                    TypeRoomId=?, 
                    State=?, 
                    TimeRecive=?, 
                    TimeLeave=?, 
                    Gift=?, 
                    Discount=?, 
                    Breakfast=?, 
                    Wifi=?, 
                    NoSmoking=?, 
                    Cancel=?, 
                    ChangeTimeRecive=?, 
                    updated_at=?, 
                    RoomName=?, 
                    Hinh_Thuc_Thanh_Toan=?, 
                    Bao_Gom_Thue_Va_Phi=? 
                    WHERE id = ?";

            $data = DB::update($sql, [
                $TypeRoomId,
                $State,
                $TimeRecive,
                $TimeLeave,
                $Gift,
                $Discount,
                $Breakfast,
                $Wifi,
                $NoSmoking,
                $Cancel,
                $ChangeTimeRecive,
                $updated_at,
                $RoomName,
                $Hinh_Thuc_Thanh_Toan,
                $Bao_Gom_Thue_Va_Phi,
                $id
            ]);


            if ($data) {
                return response()->json("Update thành công", 200);
            } else {
                return response()->json("Update thất bại", 201);
            }
        } catch (Exception $e) {
            return response()->json(
                [$e],

                500
            );
        }
    }

    public function getRoomAvailability(Request $request)
    {
        $hotelId = $request->input('hotelId');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $rooms = DB::table('room')
            ->join('typeroom', 'room.TypeRoomId', '=', 'typeroom.id')
            ->join('hotel', 'typeroom.HotelId', '=', 'hotel.id')
            ->leftJoin('bookinghotel', function ($join) use ($startDate, $endDate) {
                $join->on('room.id', '=', 'bookinghotel.RoomId')
                    ->where(function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('bookinghotel.TimeRecive', [$startDate, $endDate])
                            ->orWhereBetween('bookinghotel.TimeLeave', [$startDate, $endDate])
                            ->orWhere(function ($query) use ($startDate, $endDate) {
                                $query->where('bookinghotel.TimeRecive', '<=', $startDate)
                                    ->where('bookinghotel.TimeLeave', '>=', $endDate);
                            });
                    });
            })
            ->select([
                'room.id AS room_id',
                'room.RoomName AS room_name',
                'typeroom.Name AS type_name',
                'typeroom.Price AS type_price',
                'hotel.Name AS hotel_name',
                'bookinghotel.id AS booking_id',
                'bookinghotel.GuestId',
                'bookinghotel.TimeRecive AS check_in_date',
                'bookinghotel.TimeLeave AS check_out_date',
                'bookinghotel.State AS booking_status'
            ])
            ->where('hotel.id', $hotelId)
            ->get();

        $availabilityData = [];
        foreach ($rooms as $room) {
            if (!isset($availabilityData[$room->room_id])) {
                $availabilityData[$room->room_id] = [
                    'room_id' => $room->room_id,
                    'room_name' => $room->room_name,
                    'type_name' => $room->type_name,
                    'type_price' => $room->type_price,
                    'hotel_name' => $room->hotel_name,
                    'availability' => []
                ];
            }

            $status = 'Available';
            if ($room->booking_id) {
                $status = 'Booked';
                $availabilityData[$room->room_id]['availability'][] = [
                    'booking_id' => $room->booking_id,
                    'guest_id' => $room->GuestId,
                    'check_in_date' => $room->check_in_date,
                    'check_out_date' => $room->check_out_date,
                    'booking_status' => $room->booking_status,
                    'status' => $status
                ];
            }
        }

        $availabilityData = array_values($availabilityData);

        return response()->json($availabilityData, 200);
    }
}
