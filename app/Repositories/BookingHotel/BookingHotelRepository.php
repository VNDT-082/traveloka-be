<?php

namespace App\Repositories\BookingHotel;

use App\Models\BookingHotel_Model;
use App\Repositories\BaseRepository;

class BookingHotelRepository extends BaseRepository implements IBookingHotelRepository
{
    public function __construct(BookingHotel_Model $model)
    {
        parent::__construct($model);
    }
    public function getListByUserId($id)
    {
        return $this->model::with(['room', 'room.typeroom', 'room.typeroom.hotel'])
            ->where('GuestId', '=', $id)->get();
    }
}
