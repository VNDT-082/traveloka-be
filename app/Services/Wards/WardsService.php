<?php

namespace App\Services\Wards;

use App\Repositories\Provinces\IProvincesRepository;
use App\Repositories\Wards\IWardsRepository;
use App\Services\BaseService;

class WardsService extends BaseService implements IWardsService
{
    protected $repository;
    public function __construct(IWardsRepository $repository)
    {
        parent::__construct($repository);
    }
    public function getListByDistrictID($id)
    {
        return $this->repository->getListByDistrictID($id);
    }
}
