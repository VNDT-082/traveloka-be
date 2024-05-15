<?php

namespace App\Services\Districts;

use App\Repositories\Districts\IDistrictsRepository;
use App\Services\BaseService;

class DistrictsService extends BaseService implements IDistrictsService
{
    protected $repository;
    public function __construct(IDistrictsRepository $repository)
    {
        parent::__construct($repository);
    }
    public function getListByProvinceID($id)
    {
        return $this->repository->getListByProvinceID($id);
    }
}
