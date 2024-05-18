<?php

namespace App\Services\Provinces;

use App\Repositories\Provinces\IProvincesRepository;
use App\Services\BaseService;

class ProvincesService extends BaseService implements IProvincesService
{
    protected $repository;
    public function __construct(IProvincesRepository $repository)
    {
        parent::__construct($repository);
    }
    public function getAll()
    {
        return $this->repository->getAll();
    }
}
