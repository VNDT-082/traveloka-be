<?php

namespace App\Repositories\Room;

use App\Repositories\IBaseRepository;

interface IRoomRepository extends IBaseRepository
{
    public function getListByTypeRoomId(string $id);
    public function getOneById(string $id);
    public function updateStateRoom(string $roomID, bool $state);
}
