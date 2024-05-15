<?php

namespace App\Repositories\Provinces;

use App\Repositories\IBaseRepository;

interface IProvincesRepository extends IBaseRepository
{
    public function getAll();
    //public function getOneById($id);
}
