<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService\AuthService;
use DateTime;
use Exception;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\Stmt\TryCatch;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {

        try {
        if (
            empty($request->name) ||
            empty($request->email) ||
            empty($request->password) ||
            empty($request->Telephone) ||
            empty($request->Type)
        ) {
            // Nếu dữ liệu không hợp lệ, trả về thông báo lỗi
            return response()->json(['errors' => 'Invalid input data'], 422);
        }

        $currentDateTime = date("YmdHis");

        $randomIdAccount = "AC". $currentDateTime;

        $randomIdStaff = "SF". $currentDateTime;

        // Kiểm tra email đã tồn tại trong cơ sở dữ liệu chưa
        $existingUser = DB::table('users')->where('email', $request->email)->first();
        if ($existingUser) {
            // Nếu email đã tồn tại, trả về thông báo lỗi
            return response()->json(['errors' => 'Email already exists'], 422);
        }

        $sql = "INSERT INTO users (id , name, email, password, Telephone, Type) VALUES (?,?, ?, ?, ?, ?)";
        DB::insert($sql, [
            $randomIdAccount,
            $request->name,
            $request->email,
            Hash::make($request->password),
            $request->Telephone,
            $request->Type,
        ]);

        if($request->Type === 'Staff') {
            $sql = "INSERT INTO Staff (id, UserAccountId, Email, Telephone, Name, CCCD, Sex, Type) VALUES (?,?, ?, ?, ?, ?,?,?)";
            DB::insert($sql, [
                $randomIdStaff,
                $randomIdAccount,
                $request->email,
                $request->Telephone,
                $request->name,
                "00000000000",
                "1",
                $request->Type,
            ]);
        }

        // Thực hiện truy vấn SQL để thêm người dùng mới
        

        // Trả về phản hồi thành công nếu không có lỗi
        return response()->json(['message' => 'User registered successfully'], 200);
        } catch (Exception $e) {
            // Xử lý ngoại lệ (ví dụ: ghi log)
            Log::error('Error while registering user: ' . $e->getMessage());
            // Trả về phản hồi lỗi nếu có lỗi xảy ra
            return response()->json(['message' => 'Failed to register user'. $e->getMessage()], 500);
        }
    }

    public function checkEmailExists(Request $request)
    {
        $email = $request->input('email');

        // Kiểm tra xem email có tồn tại trong bảng users không
        $user = User::where('email', $email)->first();

        if ($user) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

     public function checkPhoneExists(Request $request)
    {
        $phone = $request->input('phone');

        // Kiểm tra xem email có tồn tại trong bảng users không
        $user = User::where('Telephone', $phone)->first();

        if ($user) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    public function loginWithEmail(Request $request)
    {
        try {
            if (empty($request->email) || empty($request->password)) {
                return response()->json(['errors' => 'Invalid input data'], 422);
            }

            $user = DB::table('users')->where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['errors' => 'Invalid credentials'], 401);
            }

            return response()->json([
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'Telephone' => $user->Telephone,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error while logging in user: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to login user' . $e->getMessage()], 500);
        }
    }

    public function loginWithPhone(Request $request)
    {
        try {
            if (empty($request->Telephone) || empty($request->password)) {
                return response()->json(['errors' => 'Invalid input data'], 422);
            }

            $user = DB::table('users')->where('Telephone', $request->Telephone)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['errors' => 'Invalid credentials'], 401);
            }

           return response()->json([
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'Telephone' => $user->Telephone,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error while logging in user: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to login user' . $e->getMessage()], 500);
        }
    }

    public function getMe(Request $request) {
        
        // Tìm kiếm thông tin người dùng dựa trên ID
        $id = $request->input('id');
        $user = DB::table('users')->where('id', $id)->first();    
        
        if(!$user){
            return response()->json(["user not found"
            ], 404);
        }
        // Kiểm tra xem người dùng có tồn tại không
        if ($user->Type === 'Staff') {  
                $getStaff = DB::table('staff')->where('UserAccountId', $user->id)->first();
            $checkStaffHaveHotel = DB::table('listStaff')->where('StaffId',$getStaff->id)->first();

            if(!$checkStaffHaveHotel) {
                 return response()->json([
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'Type' => $user->Type,
                'id_hotel' => 'underfine',
                "id_staff" => $getStaff->id
            ], 200);
            }
            else {
                return response()->json([
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'Type' => $user->Type,
                "id_staff" => $getStaff->id,
                'id_hotel' => $checkStaffHaveHotel->HotelId,
            ], 200);
            }      
        } else {
                return response()->json([
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'Telephone' => $user->Telephone,
            ], 200);
        }
    } 

    public function updateUserInfo(Request $request)
    { $sql ="";
        $method="";
        try{

            $currentDateTime = date("YmdHis");
            $resultString = "GU". $currentDateTime;


            $UserAccountId = $request->input('idAccount');
            $id= $resultString;
            $Name = $request->input('name');
            $Email = $request->input('email');
            $Telephone = $request->input('phone');
            $Sex = $request->input('sex');
            $CCCD = $request->input('cccd');
            $DateOfBirth = $request->input('dob');

            $dateTime = DateTime::createFromFormat('d/m/Y', $DateOfBirth);
            $convertedDate = $dateTime->format('Y-m-d');


            $guest = DB::table('guest')->where('UserAccountId', $UserAccountId)->first();


        if ($guest) {
            $method = "update";
            // Tìm thấy idAccount, thực hiện cập nhật thông tin
            $sql = "UPDATE guest SET Name = '{$Name}', Email = '{$Email}', Telephone = '{$Telephone}', Sex = '{$Sex}', DateOfBirth = '{$convertedDate}', CCCD = '{$CCCD}' WHERE UserAccountId = '{$UserAccountId}'";
            DB::update($sql);
            return response()->json(['message' => 'Thông tin người dùng đã được cập nhật'],200);
        } else {
           $method = "insert";
            $sql = "INSERT INTO guest (id, UserAccountId, Name, Email, Telephone, Sex, DateOfBirth,CCCD)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            DB::insert($sql, [
                $id,
                $UserAccountId ,
                $Name,
                $Email,
                $Telephone,
                $Sex,
                $convertedDate,
                $CCCD,
            ]);

            return response()->json(['message' => $method .' Người dùng mới đã được thêm' ],200);
        }
         }  
         catch (Exception $e) {
            return response()->json(['message' => $method . $sql .$e],500);
         }
    }

    public function getUserInfo(Request $request)
    {
        $id = $request->input('id');
        $guest = DB::table('guest')->where('UserAccountId', $id)->first();        
        // Kiểm tra xem người dùng có tồn tại không
        if ($guest) {
             return response()->json([
                'id' => $guest->id,
                'email' => $guest->Email,
                'name' => $guest->Name,
                'Telephone' => $guest->Telephone,
                'CCCD' => $guest->CCCD, 
                'Sex' => $guest->Sex,
                'Type' => $guest->Type,
                 'Avarta' => $guest->Avarta,
                 'DateOfBirth' => $guest->DateOfBirth,
            ], 200);
        } else {
            return response()->json([
                'message' => '$guest not found.',
            ], 404);
        }
    }


    public function loginAdminHotel(Request $request) {
        try{
            if (empty($request->email) || empty($request->password)) {
                return response()->json(['errors' => 'Invalid input data'], 422);
            }

            $user = DB::table('users')->where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['errors' => 'Invalid credentials'], 401);
            }

            $getStaff = DB::table('staff')->where('UserAccountId', $user->id)->first();
            

            $checkStaffHaveHotel = DB::table('listStaff')->where('StaffId',$getStaff->id)->first();

            // if($getStaff) {
            //     return response()->json(['errors' => $getStaff], 401);
            // }

            if(!$checkStaffHaveHotel) {
                 return response()->json([
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'Type' => $user->Type,
                'id_hotel' => 'underfine',
                "id_staff" => $getStaff->id
            ], 200);
            }
            else {
                return response()->json([
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'Type' => $user->Type,
                "id_staff" => $getStaff->id,
                'id_hotel' => $checkStaffHaveHotel->HotelId,
            ], 200);
            }



            // if($checkStaffHaveHotel->HotelId){
            //     return response()->json([
            //     'id' => $user->id,
            //     'email' => $user->email,
            //     'name' => $user->name,
            //     'Telephone' => $user->Telephone,
            //     'Type' => $user->Type,
            //     'id_hotel' => $checkStaffHaveHotel->HotelId
            // ], 200);
            // }
            // else {
            //   return response()->json([
            //     'id' => $user->id,
            //     'email' => $user->email,
            //     'name' => $user->name,
            //     'Telephone' => $user->Telephone,
            //     'Type' => $user->Type,
            //     'id_hotel' => null
            // ], 200);  
            // }
        }catch (Exception $e){
            return response()->json(['message' => $e],500);
        }
    }

}
