<?php

namespace App\Services\Staff;

use App\Models\Staff_Model;
use App\Services\BaseService;

class StaffService extends BaseService implements IStaffService
{
    public function __construct(Staff_Model $model)
    {
        parent::__construct($model);
    }
}
