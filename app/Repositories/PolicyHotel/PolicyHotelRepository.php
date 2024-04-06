<?php

namespace App\Repositories\PolicyHotel;

use App\Models\PolicyHotel_Model;
use App\Repositories\BaseRepository;

class PolicyHotelRepository extends BaseRepository implements IPolicyHotelRepository
{
    public function __construct(PolicyHotel_Model $model)
    {
        parent::__construct($model);
    }
}
