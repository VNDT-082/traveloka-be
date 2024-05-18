<?php

namespace App\Repositories\AdministrativeRegions;

use App\Models\AdministrativeRegions_Model;
use App\Repositories\BaseRepository;

class AdministrativeRegionsRepository extends BaseRepository implements IAdministrativeRegionsRepository
{
    public function __construct(AdministrativeRegions_Model $model)
    {
        parent::__construct($model);
    }
}
