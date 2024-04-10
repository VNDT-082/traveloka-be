<?php

namespace App\Services\AccountUser;

use App\Models\AccountUser_Model;
use App\Repositories\AccountUser\IAccountUserRepository;
use App\Services\BaseService;

class AccountUserService extends BaseService implements IAccountUserService
{
    protected $repository;
    public function __construct(IAccountUserRepository $repository)
    {
        parent::__construct($repository);
    }
}
