<?php

namespace App\Repositories\Guest;

use App\Models\Guest_Model;
use App\Repositories\BaseRepository;

class GuestRepository extends BaseRepository implements IGuestRepository
{
    public function __construct(Guest_Model $model)
    {
        parent::__construct($model);
    }
}
