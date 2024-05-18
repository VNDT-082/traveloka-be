<?php

namespace App\Services\Province;

use App\Repositories\Province\IProvinceRepository;
use App\Services\BaseService;

class ProvinceService extends BaseService implements IProvinceService
{
    protected $repository;
    public function __construct(IProvinceRepository $repository)
    {
        parent::__construct($repository);
    }
    public function getAll()
    {
        return $this->repository->getAll();
    }
}
