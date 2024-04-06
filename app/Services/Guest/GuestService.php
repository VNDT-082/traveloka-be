<?php

namespace App\Services\Guest;

use App\Models\Guest_Model;
use App\Services\BaseService;

class GuestService extends BaseService implements IGuestService
{
    public function __construct(Guest_Model $model)
    {
        parent::__construct($model);
    }
}
