<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Hotel\MyHotelService;
use App\Models\Hotel_Model;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;

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

        return response()->json(['hotels' => $hotels]);
    }

    public function insert_hotel(Request $request) {
         try{
            $currentDateTime = date("YmdHis");

            $randomIdHotel = "HT". $currentDateTime;

            $id= $randomIdHotel;
            $Name= $request->Name;
            $Address= $request->Address;
            $Telephone= $request->Telephone;
            $Description= (empty($request->Description)) ? "" :  $request->Description ;
            $LocationDetail=(empty($request->LocationDetail)) ? "" :  $request->LocationDetail ;
            $IsActive=(empty($request->IsActive)) ? 0 :  $request->IsActive ;
            $TimeCheckIn=$request->TimeCheckIn;
            $TimeCheckOut= $request->TimeCheckOut;
            $Type= (empty($request->Type)) ? "" :  $request->Type ;
            $StarRate= (empty($request->StarRate)) ? 0 :  $request->StarRate ;
            // $Province_Id=(empty($request->Province_Id)) ? "NULL" :  $request->Province_Id ;


            $sql = "INSERT INTO hotel (id, Name, Address, Telephone, Description, LocationDetail, IsActive, TimeCheckIn,TimeCheckOut,Type,StarRate)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";

            DB::insert($sql, [
                $id,
                $Name ,
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
         }      

           
         catch (Exception $e) {
            return response()->json(['message' => $e],500);
         }
    }

     public function insert_typeroom(Request $request) {
         try{
            $currentDateTime = date("YmdHis");
            $randomIdTyperoom = "TR". $currentDateTime;
            $id= $randomIdTyperoom;
            $HotelId= $request->HotelId;
            $Name= $request->Name;
            $ConvenientRoom= (empty($request->ConvenientRoom)) ? "" :  $request->ConvenientRoom ;
            $ConvenientBathRoom= (empty($request->ConvenientBathRoom)) ? "" :  $request->ConvenientBathRoom ;
            $FloorArea=(empty($request->FloorArea)) ? 0 :  $request->FloorArea ;
            $MaxQuantityMember=(empty($request->MaxQuantityMember)) ? 0 :  $request->MaxQuantityMember ;
            $Price=$request->Price;
            $Voi_Tam_Dung= (empty($request->Voi_Tam_Dung)) ? 0 :  $request->Voi_Tam_Dung ;
            $Ban_Cong_San_Hien= (empty($request->Ban_Cong_San_Hien)) ? 0 :  $request->Ban_Cong_San_Hien ;
            $Khu_Vuc_Cho= (empty($request->Khu_Vuc_Cho)) ? 0 :  $request->Khu_Vuc_Cho ;
            $May_Lanh= (empty($request->May_Lanh)) ? 0 :  $request->May_Lanh ;
            $Nuoc_Nong= (empty($request->Nuoc_Nong)) ? 0 :  $request->Nuoc_Nong ;
            $Bon_Tam= (empty($request->Bon_Tam)) ? 0 :  $request->Bon_Tam ;
            $TenLoaiGiuong= (empty($request->TenLoaiGiuong)) ? 0 :  $request->TenLoaiGiuong ;
            $SoLuongGiuong= (empty($request->SoLuongGiuong)) ? 0 :  $request->SoLuongGiuong ;
            $Lo_Vi_Song= (empty($request->Lo_Vi_Song)) ? 0 :  $request->Lo_Vi_Song ;
            $Tu_Lanh= (empty($request->Tu_Lanh)) ? 0 :  $request->Tu_Lanh ;
            $May_Giat= (empty($request->May_Giat)) ? 0 :  $request->May_Giat ;
            $No_Moking= (empty($request->No_Moking)) ? 0 :  $request->No_Moking ;



            // $Province_Id=(empty($request->Province_Id)) ? "NULL" :  $request->Province_Id ;


            $sql = "INSERT INTO typeroom(id, HotelId, Name, ConvenientRoom, ConvenientBathRoom, 
            FloorArea, MaxQuantityMember, Price, Voi_Tam_Dung, 
            Ban_Cong_San_Hien, Khu_Vuc_Cho, May_Lanh, Nuoc_Nong, Bon_Tam, TenLoaiGiuong, SoLuongGiuong, Lo_Vi_Song, Tu_Lanh,
             May_Giat, No_Moking)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?,?,?)";

            DB::insert($sql, [
                $id,
                $HotelId,
                $Name ,
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
            return response()->json([
                'id' => $id,
                'hotel_id' => $HotelId,
            ], 200);
         }      

           
         catch (Exception $e) {
            return response()->json(['message' => $e],500);
         }
    }

        public function getHotel(Request $request) {
        try{
            $id= $request->id;

            $sql = "SELECT 
                        hotel.*, 
                        COUNT(typeroom.id) AS number_of_room_types,
                        SUM(CASE WHEN room.State = 0 THEN 1 ELSE 0 END) AS total_rooms_state_0
                    FROM 
                        hotel
                    LEFT JOIN 
                        typeroom ON hotel.id = typeroom.HotelId
                    LEFT JOIN 
                        room ON typeroom.id = room.TypeRoomId
                    WHERE 
                        hotel.id = '$id'
                    GROUP BY 
                        hotel.id, hotel.Name, hotel.Address, hotel.Telephone, hotel.Description, hotel.LocationDetail, hotel.IsActive, hotel.TimeCheckIn, hotel.TimeCheckOut,hotel.created_at, hotel.updated_at, hotel.Type, hotel.StarRate, hotel.Province_Id ;
                    ";

            $hotel = DB::select($sql);
            return response()->json($hotel);
        }     
         catch (Exception $e) {
            return response()->json(['message' => $e],500);
         }
    }

}
