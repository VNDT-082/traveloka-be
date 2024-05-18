<?php

namespace App\Services\AdministrativeRegions;

use App\Repositories\AdministrativeRegions\IAdministrativeRegionsRepository;
use App\Services\BaseService;

class AdministrativeRegionsService extends BaseService implements IAdministrativeRegionsService
{
    protected $repository;
    public function __construct(IAdministrativeRegionsRepository $repository)
    {
        parent::__construct($repository);
    }
}
