<?php

namespace App\Services\Districts;

use App\Services\IBaseService;

interface IDistrictsService extends IBaseService
{
    public function getListByProvinceID($id);
}
