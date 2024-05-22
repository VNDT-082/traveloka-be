<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getInfoAdmin(Request $request)
    {
        $id = $request->id;

        $query = DB::table('users')
            ->leftJoin('staff', 'users.id', '=', 'staff.user_id')
            ->select('users.*', 'staff.*');

        if ($id) {
            $query->where('users.id', $id);
        }

        $usersAndStaff = $query->get();

        return response()->json($usersAndStaff, 200);
    }
}
