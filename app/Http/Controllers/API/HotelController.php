<?php

namespace App\Http\Controllers\API;


use Illuminate\Http\UploadedFile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Hotel\MyHotelService;
use App\Models\Hotel_Model;

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
                'id' => $randomIdHotel,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e], 500);
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

            $file = $request->file('file');
            $oldNameFile = $request->filename;
            $idImage = $request->idImage;




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
        $type = $request->type; // week, month, year

        $query = DB::table('booking')
            ->join('room', 'booking.id_room', '=', 'room.id')
            ->join('hotel', 'room.id_hotel', '=', 'hotel.id')
            ->select(DB::raw('SUM(booking.price) as revenue'));

        if ($idHotel) {
            $query->where('hotel.id', $idHotel);
        }

        if ($type === 'week') {
            $query->select(DB::raw('YEAR(booking.updated_at) as year, WEEK(booking.updated_at) as week'))
                ->groupBy(DB::raw('YEAR(booking.updated_at), WEEK(booking.updated_at)'));
        } elseif ($type === 'month') {
            $query->select(DB::raw('YEAR(booking.updated_at) as year, MONTH(booking.updated_at) as month'))
                ->groupBy(DB::raw('YEAR(booking.updated_at), MONTH(booking.updated_at)'));
        } elseif ($type === 'year') {
            $query->select(DB::raw('YEAR(booking.updated_at) as year'))
                ->groupBy(DB::raw('YEAR(booking.updated_at)'));
        }

        $revenue = $query->get();

        return response()->json($revenue, 200);
    }
}
