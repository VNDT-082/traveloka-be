<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\UploadedFile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Hotel\MyHotelService;
use App\Models\Hotel_Model;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;


class HotelController extends Controller
{
    protected $hotelService;

    public function __construct(MyHotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    public function getAllHotels()
    {
        $hotels = Hotel_Model::all();

        return response()->json(['hotels' => $hotels]);
    }
    public function getHotelsByProvince(Request $request)
    {
        $provinceName = $request->input('province');

        $hotels = $this->hotelService->getHotelsByProvince($provinceName);

        return response()->json($hotels);
    }

    public function insertHotel(Request $request)
    {
        try {
            $currentDateTime = date("YmdHis");

            $randomIdHotel = "HT" . $currentDateTime;

            $id = $randomIdHotel;
            $Name = $request->Name;
            $Address = $request->Address;
            $Telephone = $request->Telephone;
            $Description = (empty($request->Description)) ? "" :  $request->Description;
            $LocationDetail = (empty($request->LocationDetail)) ? "" :  $request->LocationDetail;
            $IsActive = (empty($request->IsActive)) ? 0 :  $request->IsActive;
            $TimeCheckIn = $request->TimeCheckIn;
            $TimeCheckOut = $request->TimeCheckOut;
            $Type = (empty($request->Type)) ? "" :  $request->Type;
            $StarRate = (empty($request->StarRate)) ? 0 :  $request->StarRate;
            // $Province_Id=(empty($request->Province_Id)) ? "NULL" :  $request->Province_Id ;


            $sql = "INSERT INTO hotel (id, Name, Address, Telephone, Description, LocationDetail, IsActive, TimeCheckIn,TimeCheckOut,Type,StarRate)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";

            DB::insert($sql, [
                $id,
                $Name,
                $Address,
                $Telephone,
                $Description,
                $LocationDetail,
                $IsActive,
                $TimeCheckIn,
                $TimeCheckOut,
                $Type,
                $StarRate,
            ]);


            return response()->json([
                [
                    "id" => $randomIdHotel,
                    "message" => "success",
                    "hotel_id" => $randomIdHotel,
                    "status" => true
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "id" => null,
                "message" => $e,
                "hotel_id" => null,
                "status" => false
            ], 500);
        }
    }

    public function insertTyperoom(Request $request)
    {
        try {
            $currentDateTime = date("YmdHis");
            $randomIdTyperoom = "TR" . $currentDateTime;
            $id = $randomIdTyperoom;
            $HotelId = $request->HotelId;
            $Name = $request->Name;
            $ConvenientRoom = (empty($request->ConvenientRoom)) ? "" :  $request->ConvenientRoom;
            $ConvenientBathRoom = (empty($request->ConvenientBathRoom)) ? "" :  $request->ConvenientBathRoom;
            $FloorArea = (empty($request->FloorArea)) ? 0 :  $request->FloorArea;
            $MaxQuantityMember = (empty($request->MaxQuantityMember)) ? 0 :  $request->MaxQuantityMember;
            $Price = $request->Price;
            $Voi_Tam_Dung = (empty($request->Voi_Tam_Dung)) ? 0 :  $request->Voi_Tam_Dung;
            $Ban_Cong_San_Hien = (empty($request->Ban_Cong_San_Hien)) ? 0 :  $request->Ban_Cong_San_Hien;
            $Khu_Vuc_Cho = (empty($request->Khu_Vuc_Cho)) ? 0 :  $request->Khu_Vuc_Cho;
            $May_Lanh = (empty($request->May_Lanh)) ? 0 :  $request->May_Lanh;
            $Nuoc_Nong = (empty($request->Nuoc_Nong)) ? 0 :  $request->Nuoc_Nong;
            $Bon_Tam = (empty($request->Bon_Tam)) ? 0 :  $request->Bon_Tam;
            $TenLoaiGiuong = (empty($request->TenLoaiGiuong)) ? 0 :  $request->TenLoaiGiuong;
            $SoLuongGiuong = (empty($request->SoLuongGiuong)) ? 0 :  $request->SoLuongGiuong;
            $Lo_Vi_Song = (empty($request->Lo_Vi_Song)) ? 0 :  $request->Lo_Vi_Song;
            $Tu_Lanh = (empty($request->Tu_Lanh)) ? 0 :  $request->Tu_Lanh;
            $May_Giat = (empty($request->May_Giat)) ? 0 :  $request->May_Giat;
            $No_Moking = (empty($request->No_Moking)) ? 0 :  $request->No_Moking;



            // $Province_Id=(empty($request->Province_Id)) ? "NULL" :  $request->Province_Id ;


            $sql = "INSERT INTO typeroom(id, HotelId, Name, ConvenientRoom, ConvenientBathRoom, 
            FloorArea, MaxQuantityMember, Price, Voi_Tam_Dung, 
            Ban_Cong_San_Hien, Khu_Vuc_Cho, May_Lanh, Nuoc_Nong, Bon_Tam, TenLoaiGiuong, SoLuongGiuong, Lo_Vi_Song, Tu_Lanh,
             May_Giat, No_Moking)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $typeroom = DB::insert($sql, [
                $id,
                $HotelId,
                $Name,
                $ConvenientRoom,
                $ConvenientBathRoom,
                $FloorArea,
                $MaxQuantityMember,
                $Price,
                $Voi_Tam_Dung,
                $Ban_Cong_San_Hien,
                $Khu_Vuc_Cho,
                $May_Lanh,
                $Nuoc_Nong,
                $Bon_Tam,
                $TenLoaiGiuong,
                $SoLuongGiuong,
                $Lo_Vi_Song,
                $Tu_Lanh,
                $May_Giat,
                $No_Moking,
            ]);
            if ($request->hasFile('file')) {
                $images = $request->file('file');
                $regions = $request->input('region');
                //return response()->json([count($images), count($regions)], 200);
                //return response()->json(base64_encode(file_get_contents($images->getPathName())), 500);
                if (count($images) === count($regions)) {
                    for ($i = 0; $i < count($images); $i++) {
                        $image = $images[$i];
                        $region = $regions[$i];
                        //base64_encode(file_get_contents($file->getPathName()))
                        $filename = time() . '_' . $image->getClientOriginalName();
                        $image->storeAs('public/images', $filename);

                        $baseUrl = URL::to('/');
                        $url = Storage::url('public/images/' . $filename);
                        $fullUrl = $baseUrl . $url;

                        $id_hotel = $request->input('id_hotel');
                        $id_typeroom = $id;

                        $type_room_region = $id_typeroom . ";" . $region;

                        $currentDateTime = date("YmdHis");
                        $randomIdImage = "image" . $currentDateTime . rand(0, 9999);

                        $res = DB::table('imageshotel')->insert([
                            'id' => $randomIdImage,
                            'HotelId' => $HotelId,
                            'FileName' => $fullUrl,
                            'TypeRoom' => $type_room_region,
                        ]);
                        if ($res === false) {
                            return response()->json([$res], 500);
                        }
                    }
                    if ($typeroom) {
                        return response()->json([$typeroom, $res], 200);
                    } else {
                        return response()->json([$typeroom, $res], 500);
                    }
                } else {
                    return response()->json(['message' => 'error'], 500);
                }

                // return response()->json([
                //     'id' => $id,
                //     'hotel_id' => $HotelId,
                // ], 200);
            } else {
                if ($typeroom) {
                    return response()->json([
                        'id' => $id,
                        'hotel_id' => $HotelId,
                    ], 200);
                } else {
                    return response()->json($typeroom, 500);
                }
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }

    public function selectTypeRoom(Request $request)
    {
        try {
            $id_hotel = $request->id;

            $sql = "SELECT typeroom.*,typeroom.Name as RoomName , COUNT(room.id) AS total_rooms, SUM(room.State = 0) AS state_room
                        FROM typeroom 
                        LEFT JOIN room ON room.TypeRoomId = typeroom.id
                        WHERE typeroom.HotelId = '$id_hotel'
                        GROUP BY typeroom.id, typeroom.HotelId, typeroom.Name, typeroom.ConvenientRoom, typeroom.ConvenientBathRoom, typeroom.FloorArea, typeroom.MaxQuantityMember, typeroom.Price, typeroom.Voi_Tam_Dung, typeroom.Ban_Cong_San_Hien, typeroom.Khu_Vuc_Cho, typeroom.May_Lanh, typeroom.Nuoc_Nong, typeroom.Bon_Tam,typeroom.created_at,typeroom.updated_at,typeroom.TenLoaiGiuong,typeroom.SoLuongGiuong,typeroom.Lo_Vi_Song,typeroom.SoLuongGiuong,typeroom.Lo_Vi_Song,typeroom.Tu_Lanh,typeroom.May_Giat,typeroom.No_Moking";
            $data = DB::select($sql);

            return response()->json([
                $data,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'data' => $e,
            ], 404);
        }
    }
    public function updateTypeRoom(Request $request)
    {

        try {
            $id = $request->input('id');
            $HotelId = $request->HotelId;
            $Name = $request->Name;
            $ConvenientRoom = (empty($request->ConvenientRoom)) ? "" :  $request->ConvenientRoom;
            $ConvenientBathRoom = (empty($request->ConvenientBathRoom)) ? "" :  $request->ConvenientBathRoom;
            $FloorArea = (empty($request->FloorArea)) ? 0 :  $request->FloorArea;
            $MaxQuantityMember = (empty($request->MaxQuantityMember)) ? 0 :  $request->MaxQuantityMember;
            $Price = $request->Price;
            $Voi_Tam_Dung = (empty($request->Voi_Tam_Dung)) ? 0 :  $request->Voi_Tam_Dung;
            $Ban_Cong_San_Hien = (empty($request->Ban_Cong_San_Hien)) ? 0 :  $request->Ban_Cong_San_Hien;
            $Khu_Vuc_Cho = (empty($request->Khu_Vuc_Cho)) ? 0 :  $request->Khu_Vuc_Cho;
            $May_Lanh = (empty($request->May_Lanh)) ? 0 :  $request->May_Lanh;
            $Nuoc_Nong = (empty($request->Nuoc_Nong)) ? 0 :  $request->Nuoc_Nong;
            $Bon_Tam = (empty($request->Bon_Tam)) ? 0 :  $request->Bon_Tam;
            $TenLoaiGiuong = (empty($request->TenLoaiGiuong)) ? 0 :  $request->TenLoaiGiuong;
            $SoLuongGiuong = (empty($request->SoLuongGiuong)) ? 0 :  $request->SoLuongGiuong;
            $Lo_Vi_Song = (empty($request->Lo_Vi_Song)) ? 0 :  $request->Lo_Vi_Song;
            $Tu_Lanh = (empty($request->Tu_Lanh)) ? 0 :  $request->Tu_Lanh;
            $May_Giat = (empty($request->May_Giat)) ? 0 :  $request->May_Giat;
            $No_Moking = (empty($request->No_Moking)) ? 0 :  $request->No_Moking;
            $created_at = (empty($request->created_at)) ? null :  $request->created_at;
            $updated_at = date("YmdHis");

            $sql = "UPDATE typeroom SET HotelId=?,Name=?,ConvenientRoom=?,ConvenientBathRoom=?,FloorArea=?,MaxQuantityMember=?,Price=?,Voi_Tam_Dung=?,Ban_Cong_San_Hien=?,Khu_Vuc_Cho=?,May_Lanh=?,Nuoc_Nong=?,Bon_Tam=?,created_at=?,updated_at=?,TenLoaiGiuong=?,SoLuongGiuong=?,Lo_Vi_Song=?,Tu_Lanh=?,May_Giat=?,No_Moking=? WHERE id = ?";


            $res = DB::update(
                $sql,
                [
                    $HotelId,
                    $Name,
                    $ConvenientRoom,
                    $ConvenientBathRoom,
                    $FloorArea,
                    $MaxQuantityMember,
                    $Price,
                    $Voi_Tam_Dung,
                    $Ban_Cong_San_Hien,
                    $Khu_Vuc_Cho,
                    $May_Lanh,
                    $Nuoc_Nong,
                    $Bon_Tam,
                    $created_at,
                    $updated_at,
                    $TenLoaiGiuong,
                    $SoLuongGiuong,
                    $Lo_Vi_Song,
                    $Tu_Lanh,
                    $May_Giat,
                    $No_Moking,
                    $id,
                ]
            );

            if ($res > 0) {
                return response()->json(true, 200);
            } else {
                return response()->json(false, 200);
            }
        } catch (Exception $th) {
            return response()->json($th, 500);
        }
    }

    public function getHotel(Request $request)
    {
        try {
            $id = $request->id;

            $sql = "SELECT 
                    hotel.*, 
                    COUNT(typeroom.id) AS number_of_room_types,
                    SUM(CASE WHEN room.State = 0 THEN 1 ELSE 0 END) AS total_rooms_state_0,
                    imageshotel.FileName AS hotel_image,
                    imageshotel.id AS idImage
                FROM 
                    hotel
                LEFT JOIN 
                    typeroom ON hotel.id = typeroom.HotelId
                LEFT JOIN 
                    room ON typeroom.id = room.TypeRoomId
                LEFT JOIN
                    imageshotel ON hotel.id = imageshotel.HotelId
                    AND imageshotel.TypeRoom = 'None;Ảnh bìa'
                WHERE 
                    hotel.id = '$id'
                GROUP BY 
                    hotel.id, hotel.Name, hotel.Address, hotel.Telephone, hotel.Description, hotel.LocationDetail, hotel.IsActive, hotel.TimeCheckIn, hotel.TimeCheckOut, hotel.created_at, hotel.updated_at, hotel.Type, hotel.StarRate, hotel.Province_Id, imageshotel.FileName,imageshotel.id;
                                ";

            $hotel = DB::select($sql);
            return response()->json($hotel);
        } catch (Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }

    public function updateHotel(Request $request)
    {
        try {
            $id = $request->id;
            $Name = $request->Name;
            $Address = $request->Address;
            $Telephone = $request->Telephone;
            $Description = (empty($request->Description)) ? "" :  $request->Description;
            $LocationDetail = (empty($request->LocationDetail)) ? "" :  $request->LocationDetail;
            $IsActive = (empty($request->IsActive)) ? 0 :  $request->IsActive;
            $TimeCheckIn = $request->TimeCheckIn;
            $TimeCheckOut = $request->TimeCheckOut;
            $Type = (empty($request->Type)) ? "" :  $request->Type;
            $StarRate = (empty($request->StarRate)) ? 0 :  $request->StarRate;
            $update_at = date("YmdHis");



            $sql = "UPDATE hotel SET Name='$Name',Address='$Address',Telephone='$Telephone',Description='$Description',LocationDetail='$LocationDetail',IsActive='$IsActive',TimeCheckIn='$TimeCheckIn',TimeCheckOut='$TimeCheckOut',updated_at='$update_at',Type='$Type',StarRate='$StarRate' WHERE id ='$id'";

            $hotel = DB::update($sql);

            if ($hotel > 0) {
                return response()->json(true, 200);
            } else {
                response()->json(false, 200);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }

    public function getListProvices()
    {
        try {
            $sql = 'SELECT * FROM provinces';
            $res = DB::select($sql);
            if ($res) {
                return response()->json($res, 200);
            } else {
                return response()->json([], 200);
            }
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }

    public function getListDistrict(Request $request)
    {
        try {
            $id = $request->input('id');
            $sql = "SELECT * FROM districts WHERE districts.province_code = $id";
            $res = DB::select($sql);
            if ($res) {
                return response()->json($res, 200);
            } else {
                return response()->json([], 200);
            }
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }

    public function getRevenue(Request $request)
    {
        $idHotel = $request->idHotel;

        $previousDate = date('Y-m-d', strtotime('-1 day'));
        $currentDate = date('Y-m-d');

        $currentWeekStart = Carbon::now()->startOfWeek()->toDateString();
        $currentWeekEnd = Carbon::now()->endOfWeek()->toDateString();

        $previousWeekStart = Carbon::now()->subWeek()->startOfWeek()->toDateString();
        $previousWeekEnd = Carbon::now()->subWeek()->endOfWeek()->toDateString();

        $currentMonthStart = Carbon::now()->startOfMonth()->toDateTimeString();
        $currentMonthEnd = Carbon::now()->endOfMonth()->toDateTimeString();

        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth()->toDateString();


        $startOfWeek = date('Y-m-d', strtotime('monday this week'));
        $startOfMonth = date('Y-m-01');

        $query = DB::table('bookinghotel')
            ->join('room', 'bookinghotel.RoomId', '=', 'room.id')
            ->join('typeroom', 'room.TyperoomId', '=', 'typeroom.Id')
            ->join('hotel', 'typeroom.HotelId', '=', 'hotel.id')
            ->select(DB::raw('COALESCE(SUM(bookinghotel.Price), 0) as revenue'));

        if ($idHotel) {
            $query->where('hotel.id', $idHotel);
        }

        $queryToday = clone $query;
        $revenueToday = $queryToday->whereDate('bookinghotel.CreateDate', $currentDate)->first()->revenue;

        $queryYesterday = clone $query;
        $revenueYesterday = $queryYesterday->whereDate('bookinghotel.CreateDate', $previousDate)->first()->revenue;

        // Doanh thu trong tuần này và tháng này
        $revenueWeek =
            $revenue = DB::table('bookinghotel')
            ->join('room', 'bookinghotel.RoomId', '=', 'room.id')
            ->join('typeroom', 'room.TyperoomId', '=', 'typeroom.Id')
            ->join('hotel', 'typeroom.HotelId', '=', 'hotel.id')
            ->whereBetween('bookinghotel.CreateDate', [$currentWeekStart, $currentWeekEnd])
            ->select(DB::raw('COALESCE(SUM(bookinghotel.Price), 0) as revenue'))
            ->pluck('revenue')
            ->first();






        $daysInWeek = [];
        for ($i = 0; $i < 7; $i++) {
            $daysInWeek[] = date('Y-m-d', strtotime("+$i days", strtotime($startOfWeek)));
        }

        $revenueByDayInWeek = [];
        $daysOfWeek = ['Chủ Nhật 🥴', 'Thứ 2 😖', 'Thứ 3 😏', 'Thứ 4 😌', 'Thứ 5 😊', 'Thứ 6 😜', 'Thứ 7 😝'];

        foreach ($daysInWeek as $day) {
            $dayOfWeek = Carbon::parse($day)->dayOfWeek; // Lấy thứ trong tuần (0 = Chủ Nhật, 6 = Thứ Bảy)
            $dayName = $daysOfWeek[$dayOfWeek]; // Chuyển đổi thứ trong tuần thành tên

            $revenue = $query->whereDate('bookinghotel.CreateDate', $day)->select(DB::raw('COALESCE(SUM(bookinghotel.Price), 0) as revenue'))->first()->revenue;

            $revenueByDayInWeek[] = [
                'name' => $dayName,
                'data' => $revenue,
            ];
        }

        // Tạo dữ liệu chi tiết cho biểu đồ tab Tháng
        $weeksInMonth = [];
        $startOfMonth = date('Y-m-01');
        $endOfMonth = date('Y-m-t', strtotime($startOfMonth));
        $weekNumber = 1;

        $currentWeekStart = $startOfMonth;

        while (strtotime($currentWeekStart) <= strtotime($endOfMonth)) {
            $currentWeekEnd = date('Y-m-d', strtotime('+6 days', strtotime($currentWeekStart)));
            if (strtotime($currentWeekEnd) > strtotime($endOfMonth)) {
                $currentWeekEnd = $endOfMonth; // Nếu tuần kết thúc vượt quá cuối tháng, lấy ngày cuối tháng
            }

            $weeksInMonth[] = [
                'name' => $weekNumber,
                'from' => $currentWeekStart,
                'to' => $currentWeekEnd,
            ];
            $weekNumber++;
            $currentWeekStart = date('Y-m-d', strtotime('+7 days', strtotime($currentWeekStart)));
        }


        $revenueByWeekInMonth = [];
        foreach ($weeksInMonth as $week) {
            $from = Carbon::parse($week['from'])->startOfDay()->toDateTimeString();
            $to = Carbon::parse($week['to'])->endOfDay()->toDateTimeString();


            $revenue = DB::table('bookinghotel')
                ->join('room', 'bookinghotel.RoomId', '=', 'room.id')
                ->join('typeroom', 'room.TyperoomId', '=', 'typeroom.Id')
                ->join('hotel', 'typeroom.HotelId', '=', 'hotel.id')
                ->whereBetween('bookinghotel.CreateDate', [$from, $to])
                ->select(DB::raw('COALESCE(SUM(bookinghotel.Price), 0) as revenue'))
                ->pluck('revenue')
                ->first();
            // Lưu giá trị vào mảng
            $revenueByWeekInMonth[] = [
                'name' => $week['name'],
                'data' => $revenue,
            ];
        }
        $revenueThisMonth = DB::table('bookinghotel')
            ->whereBetween('bookinghotel.CreateDate', [$currentMonthStart, $currentMonthEnd])
            ->sum('bookinghotel.Price');


        // So sánh doanh thu của tuần này với tuần trước
        $revenueThisWeek = $query->whereBetween('bookinghotel.CreateDate', [$currentWeekStart, $currentWeekEnd])->sum('bookinghotel.Price');
        $revenueLastWeek = $query->whereBetween('bookinghotel.CreateDate', [$previousWeekStart, $previousWeekEnd])->sum('bookinghotel.Price');
        $comparisonWeekVsLastWeek = ($revenueLastWeek != 0) ? (($revenueThisWeek - $revenueLastWeek) / $revenueLastWeek * 100) : 0;

        // So sánh doanh thu của tháng này với doanh thu của tháng trước
        $revenueLastMonth = $query->whereBetween('bookinghotel.CreateDate', [$previousMonthStart, $previousMonthEnd])->sum('bookinghotel.Price');
        $comparisonMonthVsLastMonth = ($revenueLastMonth != 0) ? (($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth * 100) : 0;

        // Tạo dữ liệu cho số lượng đặt phòng theo loại phòng
        $queryGetBookingTypeRooms = DB::table('bookinghotel')
            ->join('room', 'bookinghotel.RoomId', '=', 'room.id')
            ->join('typeroom', 'room.TyperoomId', '=', 'typeroom.Id')
            ->join('hotel', 'typeroom.HotelId', '=', 'hotel.id')
            ->select(DB::raw('COALESCE(SUM(bookinghotel.Price), 0) as revenue'))
            ->addSelect(DB::raw('typeroom.Name as room_type'))
            ->addSelect(DB::raw('COUNT(bookinghotel.id) as bookings_count'))
            ->groupBy('typeroom.Name');

        $resultBookingTypeRooms = $queryGetBookingTypeRooms->pluck('bookings_count', 'room_type')->toArray();

        $resultArray = [];
        foreach ($resultBookingTypeRooms as $roomType => $bookingsCount) {
            $resultArray[] = [
                'name' => $roomType,
                'value' => $bookingsCount
            ];
        }
        // Xử lý kết quả



        $response = [
            'today' => [
                'day' => $currentDate,
                'revenue' => $revenueToday,
                'comparison' => ($revenueYesterday != 0) ? (($revenueToday - $revenueYesterday) / $revenueYesterday * 100) : 0,
            ],
            'week' => [
                'from' => $startOfWeek,
                'to' => $currentDate,
                'revenue' => $revenueWeek,
                'revenueByDay' => $revenueByDayInWeek,
                'comparison' => $comparisonWeekVsLastWeek,
            ],
            'month' => [
                'from' => $startOfMonth,
                'to' => $currentMonthEnd,
                'revenue' => $revenueThisMonth,
                'revenueByWeek' => $revenueByWeekInMonth,
                'comparison' => $comparisonMonthVsLastMonth,
            ],
            'booking_rate_typeroom' => $resultArray
        ];

        // Trả về dữ liệu response
        return response()->json($response, 200);
    }

    public function insertNeighborhook(Request $request)
    {
        $data = $request->only(['id_hotel', 'name', 'category', 'is_popular', 'distance']);

        $validator = Validator::make($data, [
            'id_hotel' => 'required|string',
            'name' => 'required|string',
            'category' => 'required|string',
            'distance' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $categoryIcons = [
            'Mua sắm & quà lưu niệm' => 'shopping_area.png',
            'Nhà hàng' => 'restaurant.png',
            'Khu vui chơi' => 'entertainment_area.png',
            'Điểm nút giao thông' => 'shopping_area.png',
            'Giáo dục' => 'restaurant.png',
            'Công viên sở thú' => 'entertainment_area.png',
            'Khác' => 'entertainment_area.png',
        ];

        if (array_key_exists($data['category'], $categoryIcons)) {
            $data['icon'] = $categoryIcons[$data['category']];
        }
        $currentDateTime = date("YmdHis");
        $insert = DB::table('diadiemlancan')->insert([
            'id' =>    "NB" . $currentDateTime . rand(0, 9999),
            'HotelId' => $data['id_hotel'],
            'Name' => $data['name'],
            'Category' => $data['category'],
            'IsPopular' => (empty($data['is_popular'] ? 0 :  $data['is_popular'])),
            'ImageIcon' => $data['icon'],
            'Distance' => $data['distance'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($insert) {
            return response()->json(['success' => 'Data inserted successfully'], 200);
        } else {
            return response()->json(['error' => 'Failed to insert data'], 500);
        }
    }
}
