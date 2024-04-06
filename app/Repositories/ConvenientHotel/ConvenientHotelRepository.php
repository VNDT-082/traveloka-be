<?php

namespace App\Repositories\ConvenientHotel;

use App\Models\ConvenientHotel_Model;
use App\Repositories\BaseRepository;

class ConvenientHotelRepository extends BaseRepository implements IConvenientHotelRepository
{
    public function __construct(ConvenientHotel_Model $model)
    {
        parent::__construct($model);
    }
}
