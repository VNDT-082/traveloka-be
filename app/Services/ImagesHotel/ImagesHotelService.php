<?php

namespace App\Services\ImagesHotel;

use App\Repositories\ImagesHotel\IImagesHotelRepository;
use App\Services\BaseService;

class ImagesHotelService extends BaseService implements IImagesHotelService
{
    protected $repository;
    public function __construct(IImagesHotelRepository $repository)
    {
        parent::__construct($repository);
    }
    public function getAvartaByHotelId(string $id)
    {
        return $this->repository->getAvartaByHotelId($id);
    }
    public function getTop3ImageByHotelId(string $id)
    {
        return $this->repository->getTop3ImageByHotelId($id);
    }
}
