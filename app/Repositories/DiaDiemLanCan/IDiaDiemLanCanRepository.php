<?php

namespace App\Repositories\DiaDiemLanCan;

use App\Repositories\IBaseRepository;

interface IDiaDiemLanCanRepository extends IBaseRepository
{
    public function getListById($id);
}
