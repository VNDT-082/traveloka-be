<?php

namespace App\Services\DiaDiemLanCan;

use App\Repositories\DiaDiemLanCan\IDiaDiemLanCanRepository;
use App\Services\BaseService;

class DiaDiemLanCanService extends BaseService implements IDiaDiemLanCanService
{
    protected $repository;
    public function __construct(IDiaDiemLanCanRepository $repository)
    {
        parent::__construct($repository);
    }
    public function getListById($id)
    {
        return $this->repository->getListById($id);
    }
}
