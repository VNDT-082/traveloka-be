<?php

namespace App\Services\Room;

use App\Models\Room_Model;
use App\Repositories\BaseRepository;
use App\Repositories\Room\IRoomRepository;
use App\Services\BaseService;
use App\Services\Room\IRoomService;

class RoomService extends BaseService implements IRoomService
{
    protected $repository;
    public function __construct(IRoomRepository $repository)
    {
        parent::__construct($repository);
    }
    public function  getListByTypeRoomId(string $id)
    {
        return $this->repository->getListByTypeRoomId($id);
    }
}
