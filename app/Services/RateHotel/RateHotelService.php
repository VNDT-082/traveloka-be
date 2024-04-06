<?php

namespace App\Services\RateHotel;

use App\Models\RateHotel_Model;
use App\Services\BaseService;

class RateHotelService extends BaseService implements IRateHotelService
{
    public function __construct(RateHotel_Model $model)
    {
        parent::__construct($model);
    }
}
