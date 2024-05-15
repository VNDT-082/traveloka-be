<?php

namespace App\Repositories\Provinces;

use App\Models\Provinces_Model;
use App\Repositories\BaseRepository;

class ProvincesRepository extends BaseRepository implements IProvincesRepository
{
    public function __construct(Provinces_Model $model)
    {
        parent::__construct($model);
    }
    public function getAll()
    {
        return $this->model->all();
    }
    // public function getOneById($id){
    //     return $this->model::with()
    // }
}
