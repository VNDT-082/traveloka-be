<?php

namespace App\Services\TypeRoom;

use App\Services\IBaseService;

interface ITypeRoomService extends IBaseService
{
    public function getListByHotelId($id);
}
