<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Guest\IGuestService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function getCommentByIdHotel(Request $request)
    {
        $idHotel = $request->idHotel;

        $query = DB::table('ratehotel')
            ->leftJoin('guest', 'guest.id', '=', 'ratehotel.GuestId')
            ->select([
                'ratehotel.id as id', 'ratehotel.HotelId as id_hotel', 'ratehotel.Rating as rate', 'ratehotel.Description as description', 'ratehotel.Sach_Se as rate_clean',
                'ratehotel.Thoai_Mai as rate_comfortable', 'ratehotel.Dich_Vu as rate_service',
                'ratehotel.HinhAnh as images', 'ratehotel.created_at as created_at',
                'guest.Email as customer_email', 'guest.Name as customer_name'

            ])
            ->where('ratehotel.HotelId', $idHotel)
            ->get();
        return response()->json($query, 200);
    }
}
