<?php

namespace App\Services\ListStaff;

use App\Models\ListStaff_Model;
use App\Services\BaseService;

class ListStaffService extends BaseService implements IListStaffService
{
    public function __construct(ListStaff_Model $model)
    {
        parent::__construct($model);
    }
}
