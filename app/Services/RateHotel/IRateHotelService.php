<?php

namespace App\Services\RateHotel;

use App\Services\IBaseService;

interface IRateHotelService extends IBaseService
{
    public function getListByHotelId($id);
}
