<?php

namespace App\Services\MemberBookHotel;

use App\Repositories\MemberBookHotel\IMemberBookHotelRepository;
use App\Services\BaseService;

class MemberBookHotelService extends BaseService implements IMemberBookHotelService
{
    protected $repository;
    public function __construct(IMemberBookHotelRepository $repository)
    {
        parent::__construct($repository);
    }
}
