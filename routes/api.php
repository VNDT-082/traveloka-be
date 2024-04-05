<?php

use App\Http\Controllers\API\Guest_Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('get-all-guest',[Guest_Controller::class,'index'])->name('getAllGuest');