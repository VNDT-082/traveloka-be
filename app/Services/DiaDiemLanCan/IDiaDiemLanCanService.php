<?php

namespace App\Services\DiaDiemLanCan;

use App\Services\IBaseService;

interface IDiaDiemLanCanService extends IBaseService
{
    public function getListById($id);
}
