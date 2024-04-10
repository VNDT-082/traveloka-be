<?php

namespace App\Services\Hotel;

use App\Services\IBaseService;

interface IHotelService extends IBaseService
{
    public function search($Location, $TimeCheckIn, $QuantityMember, $MaxRoomCount, $QuantityDay);
}
