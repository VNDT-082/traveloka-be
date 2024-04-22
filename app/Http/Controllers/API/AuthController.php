<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService\AuthService;
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

        $resultString = "AC". $currentDateTime;
        // Kiểm tra email đã tồn tại trong cơ sở dữ liệu chưa
        $existingUser = DB::table('users')->where('email', $request->email)->first();
        if ($existingUser) {
            // Nếu email đã tồn tại, trả về thông báo lỗi
            return response()->json(['errors' => 'Email already exists'], 422);
        }

        // Thực hiện truy vấn SQL để thêm người dùng mới
        $sql = "INSERT INTO users (id , name, email, password, Telephone, Type) VALUES (?,?, ?, ?, ?, ?)";
        DB::insert($sql, [
            $resultString,
            $request->name,
            $request->email,
            Hash::make($request->password),
            $request->Telephone,
            $request->Type,
        ]);

        // Trả về phản hồi thành công nếu không có lỗi
        return response()->json(['message' => 'User registered successfully'], 200);
        } catch (\Exception $e) {
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
        // Kiểm tra xem người dùng có tồn tại không
        if ($user) {
             return response()->json([
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'Telephone' => $user->Telephone,
            ], 200);
        } else {
            return response()->json([
                'message' => 'User not found.',
            ], 404);
        }
    } 
}
