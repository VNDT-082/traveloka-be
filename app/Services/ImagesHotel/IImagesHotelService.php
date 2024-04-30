<?php

namespace App\Services\ImagesHotel;

use App\Services\IBaseService;

interface IImagesHotelService extends IBaseService
{
    public function getAvartaByHotelId(string $id);
}
