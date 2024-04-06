<?php

namespace App\Services\PolicyHotel;

use App\Models\PolicyHotel_Model;
use App\Services\BaseService;

class PolicyHotelService extends BaseService implements IPolicyHotelService
{
    public function __construct(PolicyHotel_Model $model)
    {
        parent::__construct($model);
    }
}
