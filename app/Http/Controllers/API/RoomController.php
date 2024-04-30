<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Room\IRoomService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

 public function insert_room(Request $request) {
         try{
            $currentDateTime = date("YmdHis") . substr((string)microtime(true), 2, 6);
            $randomIdRoom = "RO". $currentDateTime . rand(0, 9999);
            $id= $randomIdRoom;
            $TypeRoomId= $request->typeRoom_id;
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
            $RoomName= (empty($request->RoomName)) ? 0 :  $request->name_room  ;
            $Hinh_Thuc_Thanh_Toan= (empty($request->Hinh_Thuc_Thanh_Toan)) ? 1:  $request->Hinh_Thuc_Thanh_Toan ;
            $Bao_Gom_Thue_Va_Phi= (empty($request->Bao_Gom_Thue_Va_Phi)) ? 0 :  $request->Bao_Gom_Thue_Va_Phi ;
            
            $sql = "INSERT INTO room(id, TypeRoomId, State, TimeRecive, TimeLeave, Gift, Discount, Breakfast, Wifi, NoSmoking, Cancel, ChangeTimeRecive, RoomName, Hinh_Thuc_Thanh_Toan, Bao_Gom_Thue_Va_Phi)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?)";

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
            ]);
            return response()->json([
                'id' => $id,
            ], 200);
         } 
         catch (Exception $e) {
            return response()->json(['message' => $e],500);
         }
    }


}
