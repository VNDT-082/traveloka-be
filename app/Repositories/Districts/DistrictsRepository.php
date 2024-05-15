<?php

namespace App\Repositories\Districts;

use App\Models\Districts_Model;
use App\Repositories\BaseRepository;

class DistrictsRepository extends BaseRepository implements IDistrictsRepository
{
    public function __construct(Districts_Model $model)
    {
        parent::__construct($model);
    }
    public function getListByProvinceID($id)
    {
        return $this->model->where('province_code', '=', $id)->get();
    }
}
