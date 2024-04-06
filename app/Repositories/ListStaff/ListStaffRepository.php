<?php

namespace App\Repositories\ListStaff;

use App\Models\ListStaff_Model;
use App\Repositories\BaseRepository;

class ListStaffRepository extends BaseRepository implements IListStaffRepository
{
    public function __construct(ListStaff_Model $model)
    {
        parent::__construct($model);
    }
}
