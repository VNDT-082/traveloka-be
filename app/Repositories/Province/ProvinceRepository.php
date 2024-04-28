<?php

namespace App\Repositories\Province;

use App\Models\Province_Model;
use App\Repositories\BaseRepository;

class ProvinceRepository extends BaseRepository implements IProvinceRepository
{
    public function __construct(Province_Model $model)
    {
        parent::__construct($model);
    }
}
