<?php

namespace App\Repositories\MemberBookHotel;

use App\Models\MemberBookHotel_Model;
use App\Repositories\BaseRepository;

class MemberBookHotelRepository extends BaseRepository implements IMemberBookHotelRepository
{
    public function __construct(MemberBookHotel_Model $model)
    {
        parent::__construct($model);
    }
}
