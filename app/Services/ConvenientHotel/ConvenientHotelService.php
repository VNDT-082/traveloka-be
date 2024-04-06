<?php

namespace App\Services\ConvenientHotel;

use App\Services\BaseService;

class ConvenientHotelService extends BaseService implements IConvenientHotelService
{
    protected $repository;
    public function __construct(IConvenientHotelService $repository)
    {
        parent::__construct($repository);
    }
}
