<?php

namespace App\Services\RateHotel;

use App\Models\RateHotel_Model;
use App\Repositories\RateHotel\IRateHotelRepository;
use App\Services\BaseService;

class RateHotelService extends BaseService implements IRateHotelService
{
    protected $repository;
    public function __construct(IRateHotelRepository $repository)
    {
        parent::__construct($repository);
    }
}
