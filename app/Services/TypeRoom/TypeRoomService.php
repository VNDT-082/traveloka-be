<?php

namespace App\Services\TypeRoom;

use App\Models\TypeRoom_Model;
use App\Repositories\TypeRoom\ITypeRoomRepository;
use App\Services\BaseService;

class TypeRoomService extends BaseService implements ITypeRoomService
{
    protected $repository;
    public function __construct(ITypeRoomRepository $repository)
    {
        parent::__construct($repository);
    }
}
