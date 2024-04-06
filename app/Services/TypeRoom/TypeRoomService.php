<?php

namespace App\Services\TypeRoom;

use App\Models\TypeRoom_Model;
use App\Services\BaseService;

class TypeRoomService extends BaseService implements ITypeRoomService
{
    public function __construct(TypeRoom_Model $model)
    {
        parent::__construct($model);
    }
}
