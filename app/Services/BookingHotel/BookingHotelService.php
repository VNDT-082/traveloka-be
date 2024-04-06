<?php

namespace App\Services\BookingHotel;

use App\Models\BookingHotel_Model;
use App\Services\BaseService;

class BookingHotelService extends BaseService implements IBookingHotelService
{
    public function __construct(BookingHotel_Model $model)
    {
        parent::__construct($model);
    }
}
