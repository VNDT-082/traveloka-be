<?php

namespace App\Repositories\Wards;


use App\Models\Wards_Model;
use App\Repositories\BaseRepository;

class WardsRepository extends BaseRepository implements IWardsRepository
{
    public function __construct(Wards_Model $model)
    {
        parent::__construct($model);
    }
    public function getListByDistrictID($id)
    {
        return $this->model->where('district_code', '=', $id)->get();
    }
}
