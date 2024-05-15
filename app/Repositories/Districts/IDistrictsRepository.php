<?php

namespace App\Repositories\Districts;

use App\Repositories\IBaseRepository;

interface IDistrictsRepository extends IBaseRepository
{
    public function getListByProvinceID($id);
}
