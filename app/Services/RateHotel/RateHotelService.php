<?php

namespace App\Services\RateHotel;

use App\Repositories\RateHotel\IRateHotelRepository;
use App\Services\BaseService;

class RateHotelService extends BaseService implements IRateHotelService
{
    protected $repository;
    public function __construct(IRateHotelRepository $repository)
    {
        parent::__construct($repository);
    }
    public function getListByHotelId($id)
    {
        return $this->repository->getListByHotelId($id);
    }
}
