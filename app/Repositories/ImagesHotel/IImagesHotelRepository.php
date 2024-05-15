<?php

namespace App\Repositories\ImagesHotel;

use App\Repositories\IBaseRepository;

interface IImagesHotelRepository extends IBaseRepository
{
    public function getAvartaByHotelId(string $id);
    public function getTop3ImageByHotelId(string $id);
}