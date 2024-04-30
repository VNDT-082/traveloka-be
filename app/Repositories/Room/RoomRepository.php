<?php

namespace App\Repositories\Room;

use App\Models\Room_Model;
use App\Repositories\BaseRepository;

class RoomRepository extends BaseRepository implements IRoomRepository
{
    public function __construct(Room_Model $model)
    {
        parent::__construct($model);
    }
    public function  getListByTypeRoomId(string $id)
    {
        return $this->model::where('TypeRoomId', $id)->get();
    }
    public function getOneById(string $id)
    {
        return $this->model::with('typeroom', 'typeroom.hotel')->where('id', '=', $id)->first();
    }
}
