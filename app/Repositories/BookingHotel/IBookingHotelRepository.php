<?php

namespace App\Repositories\BookingHotel;

use App\Repositories\IBaseRepository;

interface IBookingHotelRepository extends IBaseRepository
{
    public function getListByUserId($id);
}
