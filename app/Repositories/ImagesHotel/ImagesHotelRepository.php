<?php

namespace App\Repositories\ImagesHotel;

use App\Models\ImagesHotel_Model;
use App\Repositories\BaseRepository;

class ImagesHotelRepository extends BaseRepository implements IImagesHotelRepository
{
    public function __construct(ImagesHotel_Model $model)
    {
        parent::__construct($model);
    }
}
