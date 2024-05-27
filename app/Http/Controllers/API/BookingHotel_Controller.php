<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $subquery = DB::table('memberbookhotel')
            ->select('BookHotelId', DB::raw('COUNT(id) as member_count'))
            ->groupBy('BookHotelId');

        $query = DB::table('bookinghotel AS b')
            ->join('room AS r', 'b.RoomId', '=', 'r.id')
            ->join('typeroom AS t', 'r.TyperoomId', '=', 't.id')
            ->join('guest AS g', 'b.GuestId', '=', 'g.id')
            ->leftJoinSub($subquery, 'mb', function ($join) {
                $join->on('b.id', '=', 'mb.BookHotelId');
            })
            ->select([
                'b.id AS booking_id',
                'g.Name AS guest_name',
                'g.Telephone AS guest_phone',
                't.Name AS room_type',
                'r.id AS room_id',
                'r.RoomName AS room_name',
                'b.TimeRecive AS check_in_date',
                'b.TimeLeave AS check_out_date',
                'b.CreateDate AS created_at',
                DB::raw('CASE WHEN b.State = 1 THEN "Đã đặt" WHEN b.State = 0 THEN "Đã hủy" ELSE "Đã thanh toán" END AS booking_status'),
                DB::raw('IFNULL((SELECT member_count FROM (' . $subquery->toSql() . ') AS subquery WHERE subquery.BookHotelId = b.id), 0) AS member_count')
            ])
            ->mergeBindings($subquery) // Bắt buộc ràng buộc
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
                'b.CreateDate'
            )
            ->get();


        if (empty($query)) {
            return response()->json([
                'message' => 'Không tìm thấy thông tin đặt phòng với ID ' . $hotelId,
            ], 404);
        }

        return response()->json($query, 200);
    }
}
