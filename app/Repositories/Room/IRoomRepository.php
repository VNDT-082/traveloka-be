<?php

namespace App\Repositories\Room;

use App\Repositories\IBaseRepository;

interface IRoomRepository extends IBaseRepository
{
    public function getListByTypeRoomId(string $id);
}
