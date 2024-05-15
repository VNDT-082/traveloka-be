<?php

namespace App\Services\Provinces;

use App\Services\IBaseService;

interface IProvincesService extends IBaseService
{
    public function getAll();
}
