<?php

namespace App\Services\ImagesHotel;

use App\Services\IBaseService;

interface IImagesHotelService extends IBaseService
{
    public function getAvartaByHotelId(string $id);
    public function getTop3ImageByHotelId(string $id);
}
