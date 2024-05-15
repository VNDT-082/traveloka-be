<?php

namespace App\Repositories\ConvenientHotel;

use App\Repositories\IBaseRepository;

interface IConvenientHotelRepository extends IBaseRepository
{
    public function getListByHotelId($id);
}
