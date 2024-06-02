<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Staff_Controller extends Controller
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

    public function insertStallToHotell(Request $request)
    {
        try {
            $currentDateTime = date("YmdHis") . substr((string)microtime(true), 2, 6);
            $id_staff = $request->id_staff;
            $id_hotel = $request->id_hotel;
            $randomIdLS = "LS" . $currentDateTime . rand(0, 9999);

            $sql = "INSERT INTO `listStaff`(`id`, `StaffId`, `HotelId`, `Roles`, `Type`, `IsActive`, `Notes`) 
                    VALUES (?,?,?,?,?,?,?)";

            DB::insert($sql, [
                $randomIdLS,
                $id_staff,
                $id_hotel,
                "Admin",
                "Admin",
                1,
                "",
            ]);


            return response()->json([
                'id_hotel' => $id_hotel,
                'id_staff' => $id_staff,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e], 500);
        }
    }
}
