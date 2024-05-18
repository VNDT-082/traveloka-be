<?php

namespace App\Services\ConvenientHotel;

use App\Repositories\ConvenientHotel\IConvenientHotelRepository;
use App\Services\BaseService;

class ConvenientHotelService extends BaseService implements IConvenientHotelService
{
    protected $repository;
    public function __construct(IConvenientHotelRepository $repository)
    {
        parent::__construct($repository);
    }
    public function getListByHotelId($id)
    {
        return $this->repository->getListByHotelId($id);
    }
}
