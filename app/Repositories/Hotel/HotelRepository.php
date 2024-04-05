<?php

namespace App\Repositories\Hotel;

use App\Models\Hotel_Model;
use App\Repositories\BaseRepository;
use App\Repositories\Hotel\IHotelRepository;

class HotelRepository extends BaseRepository implements IHotelRepository
{
    public function __construct(Hotel_Model $model)
    {
        parent::__construct($model);
    }
}
