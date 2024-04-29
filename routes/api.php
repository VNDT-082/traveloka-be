<?php

use App\Http\Controllers\API\Guest_Controller;
use App\Http\Controllers\API\Hotel_Controller;
use App\Http\Controllers\API\HotelController;
use App\Http\Controllers\API\ImagesHotel_Controller;
use App\Http\Controllers\API\Province_Controller;
use App\Http\Controllers\API\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// dang ky route Hotel
Route::prefix('hotel')->group(function () {
    //Route::get('get-all', [Hotel_Controller::class, 'index'])->name('hotel.getAll');

    //param: page
    Route::get('get-page', [Hotel_Controller::class, 'paginate'])->name('hotel.getPage');

    //param: id
    Route::get('get-one-by-id', [Hotel_Controller::class, 'show'])->name('hotel.getOneById');

    //param: $Location, $TimeCheckIn, $QuantityMember, $MaxRoomCount, $QuantityDay allow null
    Route::get('search', [Hotel_Controller::class, 'search'])->name('hotel.search');




    ### Vinh
    Route::get('/hotels-by-province', [HotelController::class, 'getHotelsByProvince']);

    Route::get('/hotels', [HotelController::class, 'getAllHotels']);
});


//Authen and info
Route::get('/check-email-exists', [AuthController::class, 'checkEmailExists']);
Route::get('/check-phone-exists', [AuthController::class, 'checkPhoneExists']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login-email', [AuthController::class, 'loginWithEmail']);
Route::post('/login-phone', [AuthController::class, 'loginWithPhone']);
Route::get('/me', [AuthController::class, 'getMe']);
Route::post('/update-user-info', [AuthController::class, 'updateUserInfo']);
Route::get('/get-user-info', [AuthController::class, 'getUserInfo']);


// Administrator Hotel Login
Route::post('/login-administrator', [AuthController::class, 'loginAdminHotel']);




// dang ky route ImagesHotel
Route::prefix('image-hotel')->group(function () {
    Route::get('get-all', [ImagesHotel_Controller::class, 'index'])->name('imagesHotel');

    //param: id
    Route::get('get-one-by-id', [ImagesHotel_Controller::class, 'show'])->name('imagesHotel.getOneById');
});

// dang ky route Province
Route::prefix('province')->group(function () {
    Route::get('get-page', [Province_Controller::class, 'paginate'])->name('province.getPage');
});

//dang ky rout Room
Route::prefix('room')->group(function () {
    Route::get('get-list-by-type-room-id', [RoomController::class, 'getListByTypeRoomID'])
        ->name('room.getListByTypeRoomID');
});
