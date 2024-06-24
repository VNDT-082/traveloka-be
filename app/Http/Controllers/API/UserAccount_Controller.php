<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\AccountUser\IAccountUserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAccount_Controller extends Controller
{
    protected $IAccountUserService;
    public function __construct(IAccountUserService $IAccountUserService)
    {
        $this->IAccountUserService = $IAccountUserService;
    }
    public function registerMobile(Request $request)
    {
        try {
            $validatedData =  $request->validate([
                'id' => 'required',
                'name' => 'required',
                'email' => 'required',
                'email_verified_at' => 'nullable',
                //'password' => 'required',
                'created_at' => 'nullable',
                'updated_at' => 'nullable',
                'Telephone ' => 'required',
                'Type' => 'required',
                'IsActive' => 'required'
            ]);
            $validatedCreateDate =  $request->validate(['password' => 'required']);
            $validatedData['password'] = Hash::make($validatedCreateDate['CreateDate']);
            $result = $this->IAccountUserService->create($validatedData);
            if ($result) {
                $validatedDataGuest =  $request->validate([
                    'id' => 'required',
                    'name' => 'required',
                    'email' => 'required',
                    'email_verified_at' => 'nullable',
                    //'password' => 'required',
                    'created_at' => 'nullable',
                    'updated_at' => 'nullable',
                    'Telephone ' => 'required',
                    'Type' => 'required',
                    'IsActive' => 'required'
                ]);
            }
            return response()->json([
                'message' => "Đã đăng ký thành công thành công",
                'status' => 'successfully',
                'result' => $result
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'message' => "Đăng ký thất bại, vui lòng thử lại.",
                'status' => 'error',
                'data' => $validatedData,
                'result' => $ex
            ], 400);
        }
    }
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
}
