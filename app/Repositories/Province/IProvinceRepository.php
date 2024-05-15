<?php

namespace App\Repositories\Province;

use App\Repositories\IBaseRepository;

interface IProvinceRepository extends IBaseRepository
{
    public function getAll();
}
