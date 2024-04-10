<?php

namespace App\Services\Hotel;

use App\Repositories\Hotel\IHotelRepository;
use App\Services\BaseService;

class HotelService extends BaseService implements IHotelService
{
    protected $repository;
    public function __construct(IHotelRepository $repository)
    {
        parent::__construct($repository);
    }
    function search($Location, $TimeCheckIn, $QuantityMember, $MaxRoomCount, $QuantityDay)
    {
        return $this->repository->search($Location, $TimeCheckIn, $QuantityMember, $MaxRoomCount, $QuantityDay);
    }
}
