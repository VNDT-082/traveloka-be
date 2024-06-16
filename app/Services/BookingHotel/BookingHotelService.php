<?php

namespace App\Services\BookingHotel;

use App\Models\BookingHotel_Model;
use App\Repositories\BookingHotel\IBookingHotelRepository;
use App\Services\BaseService;

class BookingHotelService extends BaseService implements IBookingHotelService
{
    protected $repository;
    public function __construct(IBookingHotelRepository $repository)
    {
        parent::__construct($repository);
    }
    public function getListByUserId($id)
    {
        return $this->repository->getListByUserId($id);
    }
}
