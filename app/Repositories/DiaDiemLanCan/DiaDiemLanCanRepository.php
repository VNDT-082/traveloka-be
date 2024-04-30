<?php

namespace App\Repositories\DiaDiemLanCan;

use App\Models\DiaDiemLanCan_Model;
use App\Repositories\BaseRepository;

class DiaDiemLanCanRepository extends BaseRepository implements IDiaDiemLanCanRepository
{
    public function __construct(DiaDiemLanCan_Model $model)
    {
        parent::__construct($model);
    }
    public function getListById($id)
    {
        return $this->model::where('HotelId', '=', $id)->get();
    }
}
