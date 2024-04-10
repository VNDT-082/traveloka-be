<?php

namespace App\Services\ListStaff;

use App\Models\ListStaff_Model;
use App\Repositories\ListStaff\IListStaffRepository;
use App\Services\BaseService;

class ListStaffService extends BaseService implements IListStaffService
{
    protected $repository;
    public function __construct(IListStaffRepository $repository)
    {
        parent::__construct($repository);
    }
}
