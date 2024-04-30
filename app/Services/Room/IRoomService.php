<?php

namespace App\Services\Room;

use App\Services\IBaseService;

interface IRoomService extends IBaseService
{
    public function getListByTypeRoomId(string $id);
    public function getOneById(string $id);
}
