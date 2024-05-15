<?php

namespace App\Repositories\TypeRoom;

use App\Repositories\IBaseRepository;

interface ITypeRoomRepository extends IBaseRepository
{
    public function getListByHotelId($id);
}
