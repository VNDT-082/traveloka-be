<?php

namespace App\Repositories\AdministrativeUnits;

use App\Models\AdministrativeUnits_Model;
use App\Repositories\BaseRepository;

class AdministrativeUnitsRepository extends BaseRepository implements IAdministrativeUnitsRepository
{
    public function __construct(AdministrativeUnits_Model $model)
    {
        parent::__construct($model);
    }
}
