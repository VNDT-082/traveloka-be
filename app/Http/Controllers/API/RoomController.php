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

 public function insertRoom(Request $request) {
         try{
            $currentDateTime = date("YmdHis") . substr((string)microtime(true), 2, 6);
            $randomIdRoom = "RO". $currentDateTime . rand(0, 9999);
            $id= $randomIdRoom;
            $TypeRoomId= $request->TypeRoomId;
            $State= (empty($request->State)) ? 0 :  $request->State ;
            $TimeRecive= (empty($request->TimeRecive)) ? null :  $request->TimeRecive ;
            $TimeLeave= (empty($request->TimeLeave)) ? null :  $request->TimeLeave ;
            $Gift=(empty($request->Gift)) ? 0 :  $request->Gift ;
            $Discount=(empty($request->Discount)) ? 0 :  $request->Discount ;
            $Breakfast= (empty($request->Breakfast)) ? 0 :  $request->Breakfast ;
            $Wifi= (empty($request->Wifi)) ? 0 :  $request->Wifi ;
            $NoSmoking= (empty($request->NoSmoking)) ? 1 :  $request->NoSmoking ;
            $Cancel= (empty($request->Cancel)) ? 0 :  $request->Cancel ;
            $ChangeTimeRecive= (empty($request->ChangeTimeRecive)) ? 0 :  $request->ChangeTimeRecive ;
            $RoomName= (empty($request->RoomName)) ? 0 :  $request->RoomName  ;
            $Hinh_Thuc_Thanh_Toan= (empty($request->Hinh_Thuc_Thanh_Toan)) ? 1:  $request->Hinh_Thuc_Thanh_Toan ;
            $Bao_Gom_Thue_Va_Phi= (empty($request->Bao_Gom_Thue_Va_Phi)) ? 0 :  $request->Bao_Gom_Thue_Va_Phi ;
            $createAt =  date("YmdHis");
            $sql = "INSERT INTO room(id, TypeRoomId, State, TimeRecive, TimeLeave, Gift, Discount, Breakfast, Wifi, NoSmoking, Cancel, ChangeTimeRecive, RoomName, Hinh_Thuc_Thanh_Toan, Bao_Gom_Thue_Va_Phi, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?)";

            DB::insert($sql, [
                $id,
                $TypeRoomId,
                $State ,
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
         } 
         catch (Exception $e) {
            return response()->json(['message' => $e],500);
         }
    }

    public function selectRoom (Request $request) {
        try 
        {
           $id_hotel = $request->id;

            $sql = "SELECT typeroom.Name AS type_name, typeroom.Price AS type_price, hotel.Name AS hotel_name, room.* 
                    FROM typeroom
                    INNER JOIN hotel ON typeroom.HotelId = hotel.id
                    INNER JOIN room ON room.TypeRoomId = typeroom.id
                    WHERE hotel.id = '$id_hotel'";
            $data = DB::select($sql);

            return response()->json(
                $data
            , 200);


        }
        catch(Exception $e)
        {
            return response()->json([
                'data' => $e,
            ], 404);
        }
    }

    public function selectTypeRoom (Request $request) {
        try 
        {
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


        }
        catch(Exception $e)
        {
            return response()->json([
                'data' => $e,
            ], 404);
        }
    }
}
