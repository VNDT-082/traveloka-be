<?php

namespace App\Repositories\Wards;

use App\Repositories\IBaseRepository;

interface IWardsRepository extends IBaseRepository
{
    public function getListByDistrictID($id);
}
