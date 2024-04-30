<?php

use App\Http\Controllers\API\DiaDiemLanCan_Controller;
use App\Http\Controllers\API\Guest_Controller;
use App\Http\Controllers\API\Hotel_Controller;
use App\Http\Controllers\API\ImagesHotel_Controller;
use App\Http\Controllers\API\Province_Controller;
use App\Http\Controllers\API\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
});

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
