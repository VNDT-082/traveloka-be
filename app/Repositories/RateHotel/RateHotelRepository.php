<?php

namespace App\Repositories\RateHotel;

use App\Models\RateHotel_Model;
use App\Repositories\BaseRepository;

class RateHotelRepository extends BaseRepository implements IRateHotelRepository
{
    public function __construct(RateHotel_Model $model)
    {
        parent::__construct($model);
    }
}
