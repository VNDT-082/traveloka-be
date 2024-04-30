<?php

namespace App\Repositories\ImagesHotel;

use App\Repositories\IBaseRepository;

interface IImagesHotelRepository extends IBaseRepository
{
    public function getAvartaByHotelId(string $id);
}
