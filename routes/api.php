<?php

use App\Http\Controllers\API\BookingHotel_Controller;
use App\Http\Controllers\API\DiaDiemLanCan_Controller;
use App\Http\Controllers\API\Guest_Controller;
use App\Http\Controllers\API\Hotel_Controller;
use App\Http\Controllers\API\HotelController;
use App\Http\Controllers\API\ImagesHotel_Controller;
use App\Http\Controllers\API\Province_Controller;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

use App\Http\Controllers\API\Districts_Controller;
use App\Http\Controllers\API\Provinces_Controller;
use App\Http\Controllers\API\Wards_Controller;

use App\Http\Controllers\API\Staff_Controller;

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

    //param: id
    Route::get('get-list-by-province-id', [Hotel_Controller::class, 'getHotelsByProvinceId'])->name('hotel.getHotelsByProvinceId');

    Route::get('/hotels-by-province', [HotelController::class, 'getHotelsByProvince']);

    Route::get('/hotels', [HotelController::class, 'getAllHotels']);

    Route::post('/insert-hotel', [HotelController::class, 'insertHotel']);

    Route::get('/get-hotel', [HotelController::class, 'getHotel']);

    Route::put('/update-hotel', [HotelController::class, 'updateHotel']);

    Route::get('/get-renvenu', [HotelController::class, 'getRevenue']);
});
//Booking

Route::get('/all-booking', [BookingHotel_Controller::class, 'getBookingsByHotelId']);




//Address

Route::get('/address/provices', [HotelController::class, 'getListProvices']);
Route::get('/address/provices/district', [HotelController::class, 'getListDistrict']);


//Room

Route::post('/room/insert-room', [RoomController::class, 'insertRoom']);
Route::get('/room/select-room', [RoomController::class, 'selectRoom']);
Route::put('/room/update-room', [RoomController::class, 'updateRoom']);

//TypeRoom
Route::post('/room/insert-typeroom', [HotelController::class, 'insertTyperoom']);
Route::get('/room/select-typeroom', [HotelController::class, 'selectTypeRoom']);
Route::put('/room/update-typeroom', [HotelController::class, 'updateTypeRoom']);
Route::get('/image/select-image-by-typeroom', [ImageController::class, 'selectImageByIdTypeRoom']);
Route::post('/upload-multiple-image', [ImageController::class, 'uploadMultipleImageTypeRoom']);
Route::delete('/delete-image-typeroom', [ImageController::class, 'deleteImageByIdTypeRoom']);

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
// Route::get('/information-administrator', [UserController::class, 'getInfoAdmin']);


//Upload
Route::post('/upload-image', [ImageController::class, 'upload']);
Route::post('/update-cover-image-hotel', [ImageController::class, 'updateCoverImage']);


//?? Staff

Route::post('/staff/insert', [Staff_Controller::class, 'insertStallToHotell']);


// dang ky route ImagesHotel
Route::prefix('image-hotel')->group(function () {
    Route::get('get-all', [ImagesHotel_Controller::class, 'index'])->name('imagesHotel');
    Route::get('get-avarta-by-hotel-id', [ImagesHotel_Controller::class, 'getAvartaByHotelId'])
        ->name('imagesHotel.getAvartaByHotelId');



    //param: id
    Route::get('get-one-by-id', [ImagesHotel_Controller::class, 'show'])->name('imagesHotel.getOneById');
});

// dang ky route Province
Route::prefix('province')->group(function () {
    Route::get('get-page', [Province_Controller::class, 'paginate'])->name('province.getPage');
    Route::get('get-all', [Province_Controller::class, 'getAll'])->name('province.getAll');
});

//dang ky rout Room
Route::prefix('room')->group(function () {
    Route::get('get-list-by-type-room-id', [RoomController::class, 'getListByTypeRoomID'])
        ->name('room.getListByTypeRoomID');
    Route::get('get-one-by-id', [RoomController::class, 'getOneById'])->name('room.getOneByID');
});

// dang ky route DiaDiemLanCan
Route::prefix('diadiemlancan')->group(function () {
    Route::get('get-list-by-id', [DiaDiemLanCan_Controller::class, 'getListById'])->name('diadiemlancan.getListById');
});

//dang ky guest
Route::prefix('guest')->group(function () {
    Route::get('get-one-by-email', [Guest_Controller::class, 'getOneByEmail'])->name('guest.getOneByEmail');
});


//dang ky tinh
Route::prefix('provinces')->group(function () {
    Route::get('get-all', [Provinces_Controller::class, 'getAll'])->name('provinces.getAll');
});
//dang ky huyen
Route::prefix('districts')->group(function () {
    Route::get('get-list-by-provinces-id', [Districts_Controller::class, 'getListByProvinceID'])->name(' districts.getListByProvinceID');
});
//dang ky xa
Route::prefix('wards')->group(function () {
    Route::get('get-list-by-district-id', [Wards_Controller::class, 'getListByDistrictID'])->name('wards.getListByDistrictID');
});
