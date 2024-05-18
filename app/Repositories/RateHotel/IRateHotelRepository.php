<?php

namespace App\Repositories\RateHotel;

use App\Repositories\IBaseRepository;

interface IRateHotelRepository extends IBaseRepository
{
    public function getListByHotelId($id);
}
