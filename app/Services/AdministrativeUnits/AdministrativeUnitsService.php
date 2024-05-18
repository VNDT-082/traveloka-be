<?php

namespace App\Services\AdministrativeUnits;

use App\Repositories\AdministrativeUnits\IAdministrativeUnitsRepository;
use App\Services\BaseService;

class AdministrativeUnitsService extends BaseService implements IAdministrativeUnitsService
{
    protected $repository;
    public function __construct(IAdministrativeUnitsRepository $repository)
    {
        parent::__construct($repository);
    }
}
