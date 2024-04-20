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
    // Kiểm tra dữ liệu đầu vào
    if (
         empty($request->id) ||
        empty($request->name) ||
        empty($request->email) ||
        empty($request->password) ||
        empty($request->Telephone) ||
        empty($request->Type)
    ) {
        // Nếu dữ liệu không hợp lệ, trả về thông báo lỗi
        return response()->json(['errors' => 'Invalid input data'], 422);
    }

    
  

    // Kiểm tra email đã tồn tại trong cơ sở dữ liệu chưa
    $existingUser = DB::table('users')->where('email', $request->email)->first();
    if ($existingUser) {
        // Nếu email đã tồn tại, trả về thông báo lỗi
        return response()->json(['errors' => 'Email already exists'], 422);
    }

    // Thực hiện truy vấn SQL để thêm người dùng mới
    $sql = "INSERT INTO users (id , name, email, password, Telephone, Type) VALUES (?,?, ?, ?, ?, ?)";
    DB::insert($sql, [
        $request->id,
        $request->name,
        $request->email,
        Hash::make($request->password),
        $request->Telephone,
        $request->Type,
    ]);

    // Trả về phản hồi thành công nếu không có lỗi
    return response()->json(['message' => 'User registered successfully'], 201);
} catch (\Exception $e) {
    // Xử lý ngoại lệ (ví dụ: ghi log)
    Log::error('Error while registering user: ' . $e->getMessage());
    // Trả về phản hồi lỗi nếu có lỗi xảy ra
    return response()->json(['message' => 'Failed to register user'], 500);
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

    
}
