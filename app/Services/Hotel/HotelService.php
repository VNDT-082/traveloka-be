<?php

namespace App\Services\Hotel;

use App\Repositories\Hotel\IHotelRepository;
use App\Services\BaseService;

class HotelService extends BaseService implements IHotelService
{
    protected $repository;
    public function __construct(IHotelRepository $repository)
    {
        parent::__construct($repository);
    }
    public function search(
        $province = null,
        $totalnight = null,
        $totalmember = null,
        $totalmemberchild = null,
        $timereceive = null,
        $totalroom = null
    ) {
        return $this->repository->search(
            $province,
            $totalnight,
            $totalmember,
            $totalmemberchild,
            $timereceive,
            $totalroom
        );
    }
    public function getListByProvinceId($id)
    {
        return $this->repository->getListByProvinceId($id);
    }
    public function getTop5ByProvinceId($id)
    {
        return $this->repository->getTop5ByProvinceId($id);
    }
    public function getTop10New()
    {
        return $this->repository->getTop10New();
    }
}
