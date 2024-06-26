<?php

namespace App\Services\BookingHotel;

use App\Services\IBaseService;

interface IBookingHotelService extends IBaseService
{
    public function getListByUserId($id);
}
