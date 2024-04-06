<?php

namespace App\Repositories\Staff;

use App\Models\Staff_Model;
use App\Repositories\BaseRepository;

class StaffRepository extends BaseRepository implements IStaffRepository
{
    public function __construct(Staff_Model $model)
    {
        parent::__construct($model);
    }
}
