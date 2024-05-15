<?php

namespace App\Services\ConvenientHotel;

use App\Services\IBaseService;

interface IConvenientHotelService extends IBaseService
{
    public function getListByHotelId($id);
}