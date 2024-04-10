<?php

namespace App\Services\PolicyHotel;


use App\Repositories\PolicyHotel\IPolicyHotelRepository;
use App\Services\BaseService;

class PolicyHotelService extends BaseService implements IPolicyHotelService
{
    protected $repository;
    public function __construct(IPolicyHotelRepository $repository)
    {
        parent::__construct($repository);
    }
}
