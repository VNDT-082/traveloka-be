<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SupperAdminController extends Controller
{
    public function getUserRegistrationsByMonth()
    {
        $registrations = DB::table('users')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        $result = [];
        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];

        foreach ($months as $num => $name) {
            $result[$num] = [
                'name' => $name,
                'total' => 0
            ];
        }

        foreach ($registrations as $registration) {
            if (isset($result[$registration->month])) {
                $result[$registration->month]['total'] = $registration->total;
            }
        }

        $result = array_values($result);

        return response()->json($result, 200);
    }

    public function getTopHotelsByRevenue(Request $request)
    {
        $topHotels = DB::select("
             SELECT
                hotel.id AS hotel_id,
                hotel.Name AS hotel_name,
                SUM(bookinghotel.Price) AS total_revenue,
                listStaff.StaffId AS staff_id,
                staff.Email AS staff_email
            FROM
                bookinghotel
            JOIN
                room ON bookinghotel.RoomId = room.id
            JOIN
                typeroom ON room.TypeRoomId = typeroom.id
            JOIN
                hotel ON typeroom.HotelId = hotel.id
            JOIN
                listStaff ON hotel.id = listStaff.HotelId
            JOIN
                staff ON listStaff.StaffId = staff.id
            GROUP BY
                hotel.id, hotel.Name, listStaff.StaffId, staff.email
            ORDER BY
                total_revenue DESC
            LIMIT 6;

    ");

        return response()->json($topHotels);
    }

    public function getTotalRegisterByType(Request $request)
    {
        $currentMonth = date('Y-m');

        $registrations = DB::table('users')
            ->select(DB::raw('
                DATE_FORMAT(created_at, "%Y-%m") as month,
                Type,
                COUNT(*) as total
            '))
            ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), '=', $currentMonth)
            ->groupBy('month', 'Type')
            ->get();

        $data = [
            'month' => $currentMonth,
            'staff' => 0,
            'guest' => 0,
        ];

        foreach ($registrations as $registration) {
            if ($registration->Type === 'Staff') {
                $data['staff'] = $registration->total;
            } else if ($registration->Type === 'Guest') {
                $data['guest'] = $registration->total;
            }
        }

        return response()->json($data);
    }

    public function getCurrentMonthBookings(Request $request)
    {
        $currentMonth = date('Y-m');

        $totalBookings = DB::table('bookinghotel')
            ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), '=', $currentMonth)
            ->count();

        return response()->json([
            'month' => $currentMonth,
            'total_bookings' => $totalBookings
        ]);
    }

    public function getStatistics(Request $request)
    {
        $month = $request->input('month', date('Y-m'));

        $registrations = DB::table('users')
            ->select(DB::raw('
                DATE_FORMAT(created_at, "%Y-%m") as month,
                Type,
                COUNT(*) as total
            '))
            ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), '=', $month)
            ->groupBy('month', 'Type')
            ->get();

        $months = [
            $month => ['staff' => 0, 'guest' => 0]
        ];

        foreach ($registrations as $registration) {
            if ($registration->Type === 'Staff') {
                $months[$registration->month]['staff'] = $registration->total;
            } else if ($registration->Type === 'Guest') {
                $months[$registration->month]['guest'] = $registration->total;
            }
        }

        $totalBookings = DB::table('bookinghotel')
            ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), '=', $month)
            ->count();

        $topHotels = DB::table('bookinghotel')
            ->join('room', 'bookinghotel.RoomId', '=', 'room.id')
            ->join('typeroom', 'room.TypeRoomId', '=', 'typeroom.id')
            ->join('hotel', 'typeroom.HotelId', '=', 'hotel.id')
            ->join('listStaff', 'hotel.id', '=', 'listStaff.HotelId')
            ->join('staff', 'listStaff.StaffId', '=', 'staff.id')
            ->select(
                'hotel.id as hotel_id',
                'hotel.Name as hotel_name',
                'staff.Email as staff_email',
                DB::raw('SUM(bookinghotel.Price) as total_revenue')
            )
            ->where('listStaff.Roles', 'Admin')
            ->where(DB::raw('DATE_FORMAT(bookinghotel.created_at, "%Y-%m")'), '=', $month)
            ->groupBy('hotel.id', 'hotel.Name', 'staff.Email')
            ->orderBy('total_revenue', 'DESC')
            ->limit(6)
            ->get();

        $data = [
            'month' => $month,
            'registrations' => $months[$month],
            'total_bookings' => $totalBookings,
            'top_hotels' => $topHotels
        ];

        return response()->json($data);
    }

    public function getHotelRegisterByMonth(Request $request)
    {
        try {
            $monthYear = $request->input('monthYear');

            $startDate = date('Y-m-01', strtotime($monthYear));
            $endDate = date('Y-m-t', strtotime($monthYear));

            $registrations = DB::table('users')
                ->join('staff', 'users.id', '=', 'staff.UserAccountId')
                ->join('listStaff', 'staff.id', '=', 'listStaff.StaffId')
                ->join('hotel', 'hotel.id', '=', 'listStaff.HotelId')
                ->where('users.Type', '=', 'Staff')
                ->whereBetween(DB::raw('DATE(users.created_at)'), [$startDate, $endDate])
                ->select(
                    'users.id as user_id',
                    'users.email as user_email',
                    'users.name as user_name',
                    'users.Telephone as user_phone',
                    'users.created_at as user_created',
                    'listStaff.HotelId as hotel_id',
                    'hotel.Name as hotel_name',
                    'hotel.address as hotel_address',
                    'hotel.Telephone as hotel_phone',
                    'hotel.Description as hotel_decs',
                    'hotel.created_at as hotel_created'
                )
                ->get();

            foreach ($registrations as $registration) {
                $roomCounts = DB::table('room')
                    ->join('typeroom', 'room.TypeRoomId', '=', 'typeroom.id')
                    ->where('typeroom.HotelId', '=', $registration->hotel_id)
                    ->groupBy('typeroom.Name', 'typeroom.Price', 'typeroom.MaxQuantityMember', 'typeroom.TenLoaiGiuong', 'typeroom.SoLuongGiuong', 'typeroom.ConvenientRoom')
                    ->select(
                        'typeroom.Name as type_room_name',
                        'typeroom.Price as typeroom_price',
                        'typeroom.MaxQuantityMember as typeroom_maxpeople',
                        'typeroom.TenLoaiGiuong as typeroom_type_bed',
                        'typeroom.SoLuongGiuong as typeroom_num_bed',
                        'typeroom.ConvenientRoom as typeroom_convenient',
                        DB::raw('COUNT(*) as room_count')
                    )
                    ->get();

                $registration->rooms = $roomCounts;
            }

            return response()->json($registrations, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch data', 'message' => $e->getMessage()], 500);
        }
    }
    public function getProvinceCounts()
    {
        $hotels = DB::table('hotel')->select('Address')->get();
        $provinceCounts = [];

        foreach ($hotels as $hotel) {
            $addressParts = explode(',', $hotel->Address);
            $province = trim(end($addressParts));

            if (isset($provinceCounts[$province])) {
                $provinceCounts[$province]++;
            } else {
                $provinceCounts[$province] = 1;
            }
        }

        arsort($provinceCounts);

        return response()->json($provinceCounts, 200);
    }

    public function getTopProvinceBooking()
    {
        $bookings = DB::table('bookinghotel as b')
            ->join('room as r', 'b.RoomId', '=', 'r.id')
            ->join('typeroom as tr', 'r.TypeRoomId', '=', 'tr.id')
            ->join('hotel as h', 'tr.hotelId', '=', 'h.id')
            ->select('h.Name', 'h.Address', 'h.id', DB::raw('COUNT(b.id) as BookingCount'))
            ->groupBy('h.Name', 'h.Address', 'h.id')
            ->get();

        $provinceCounts = [];

        foreach ($bookings as $hotel) {
            $addressParts = explode(',', $hotel->Address);
            $province = trim(end($addressParts));

            if (isset($provinceCounts[$province])) {
                $provinceCounts[$province] += $hotel->BookingCount;
            } else {
                $provinceCounts[$province] = $hotel->BookingCount;
            }
        }
        $provinceCountsArray = [];
        foreach ($provinceCounts as $province => $count) {
            $provinceCountsArray[] = [
                'province' => $province,
                'booking_count' => $count,
            ];
        }

        return response()->json($provinceCountsArray, 200);
    }

    public function getAllHotel(Request $request)
    {
        try {
            $registrations = DB::table('hotel')
                ->join('listStaff', 'hotel.id', '=', 'listStaff.HotelId')
                ->join('staff', 'listStaff.StaffId', '=', 'staff.id')
                ->join('users', 'staff.UserAccountId', '=', 'users.id')
                ->where('users.Type', '=', 'Staff')
                ->select(
                    'users.id as user_id',
                    'users.email as user_email',
                    'users.name as user_name',
                    'users.Telephone as user_phone',
                    'users.created_at as user_created',
                    'hotel.id as hotel_id',
                    'hotel.Name as hotel_name',
                    'hotel.address as hotel_address',
                    'hotel.Telephone as hotel_phone',
                    'hotel.Description as hotel_decs',
                    'hotel.created_at as hotel_created',
                    'hotel.IsActive as is_active',
                    DB::raw('(SELECT COUNT(DISTINCT typeroom.id) FROM typeroom WHERE typeroom.HotelId = hotel.id) as total_room_types'),
                    DB::raw('(SELECT COUNT(room.id) FROM room JOIN typeroom ON room.TypeRoomId = typeroom.id WHERE typeroom.HotelId = hotel.id) as total_rooms')
                )
                ->distinct()
                ->get();

            $registrations->transform(function ($registration) {
                return (object) [
                    'user' => (object) [
                        'id' => $registration->user_id,
                        'email' => $registration->user_email,
                        'name' => $registration->user_name,
                        'phone' => $registration->user_phone,
                        'created_at' => $registration->user_created,
                    ],
                    'hotel' => (object) [
                        'id' => $registration->hotel_id,
                        'name' => $registration->hotel_name,
                        'address' => $registration->hotel_address,
                        'phone' => $registration->hotel_phone,
                        'description' => $registration->hotel_decs,
                        'created_at' => $registration->hotel_created,
                        'is_active' => $registration->is_active,
                        'total_room_types' => $registration->total_room_types,
                        'total_rooms' => $registration->total_rooms,
                    ],
                ];
            });

            return response()->json($registrations, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch data', 'message' => $e->getMessage()], 500);
        }
    }
}
