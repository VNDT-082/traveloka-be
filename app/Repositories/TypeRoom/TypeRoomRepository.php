<?php

namespace App\Repositories\TypeRoom;

use App\Models\TypeRoom_Model;
use App\Repositories\BaseRepository;

class TypeRoomRepository extends BaseRepository implements ITypeRoomRepository
{
    public function __construct(TypeRoom_Model $model)
    {
        parent::__construct($model);
    }
}
