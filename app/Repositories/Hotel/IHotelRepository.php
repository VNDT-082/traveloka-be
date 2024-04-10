<?php

namespace App\Repositories\Hotel;

use App\Repositories\IBaseRepository;

interface IHotelRepository extends IBaseRepository
{
    public function search($Location, $TimeCheckIn, $QuantityMember, $MaxRoomCount, $QuantityDay);
}
