<?php

namespace App\Services\Staff;


use App\Repositories\Staff\IStaffRepository;
use App\Services\BaseService;

class StaffService extends BaseService implements IStaffService
{
    protected $repository;
    public function __construct(IStaffRepository $repository)
    {
        parent::__construct($repository);
    }
}
