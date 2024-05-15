<?php

namespace App\Services\Wards;

use App\Services\IBaseService;

interface IWardsService extends IBaseService
{
    public function getListByDistrictID($id);
}
