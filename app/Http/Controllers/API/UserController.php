<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function getFullInfoUser(Request $request)
    {
        $idUser = $request->idUser;

        $userInfo = DB::table('users')
            ->join('staff', 'users.id', '=', 'staff.UserAccountId')
            ->join('listStaff', 'staff.id', '=', 'listStaff.StaffId')
            ->where('users.id', $idUser)
            ->select(
                'users.id as account_id',
                'users.email as account_email',
                'users.updated_at as account_update_at',
                'staff.updated_at as info_update_at',
                'staff.Email as user_email',
                'staff.Telephone as user_phone',
                'staff.Name as user_name',
                'staff.Sex as user_gender',
                'staff.DateOfBirth as user_dob',
                'listStaff.Roles as user_role',

            )
            ->first();
        return response()->json($userInfo, 200);
    }

    public function updateUserInfo(Request $request)
    {
        // Lấy dữ liệu từ request
        $idUser = $request->input('account_id');
        $userEmail = $request->input('user_email');
        $userPhone = $request->input('user_phone');
        $userName = $request->input('user_name');
        $userGender = $request->input('user_gender');
        $userDob = Carbon::parse($request->input('user_dob'))->format('Y-m-d');

        DB::beginTransaction();

        try {
            // DB::table('users')
            //     ->where('id', $idUser)
            //     ->update([
            //         'email' => $userEmail,
            //     ]);

            DB::table('staff')
                ->where('UserAccountId', $idUser)
                ->update([
                    'Email' => $userEmail,
                    'Telephone' => $userPhone,
                    'Name' => $userName,
                    'Sex' => (int)$userGender,
                    'DateOfBirth' => $userDob,
                    'updated_at' => now(),
                ]);


            DB::commit();

            return response()->json('Cập nhật thông tin thành công', 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json($e->getMessage(), 500);
        }
    }

    public function updateUserGuestInfo(Request $request)
    {
        // Lấy dữ liệu từ request
        $idUser = $request->input('account_id');
        $userEmail = $request->input('user_email');
        $userPhone = $request->input('user_phone');
        $userName = $request->input('user_name');
        $userGender = $request->input('user_gender');
        $userDob = Carbon::parse($request->input('user_dob'))->format('Y-m-d');

        DB::beginTransaction();

        try {
            DB::table('guest')
                ->where('UserAccountId', $idUser)
                ->update([
                    'Email' => $userEmail,
                    'Telephone' => $userPhone,
                    'Name' => $userName,
                    'Sex' => (int)$userGender,
                    'DateOfBirth' => $userDob,
                    'updated_at' => now(),
                ]);


            DB::commit();

            return response()->json('Cập nhật thông tin thành công', 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json($e->getMessage(), 500);
        }
    }

    public function changePassword(Request $request)
    {
        $user = DB::table('users')->where('id', $request->idUser)->first();

        if (!$user) {
            return response()->json(['success' => false, 'mess' => 'User not found'], 404);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'mess' => 'Current password is incorrect'], 400);
        }

        DB::table('users')
            ->where('id', $request->idUser)
            ->update(['password' => Hash::make($request->new_password), 'updated_at' => now()]);

        return response()->json(['success' => true, 'mess' => 'Password updated successfully'], 200);
    }
}
