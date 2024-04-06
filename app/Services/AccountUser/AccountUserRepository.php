<?php

namespace App\Services\AccountUser;

use App\Models\AccountUser_Model;
use App\Services\BaseService;

class AccountUserService extends BaseService implements IAccountUserService
{
    public function __construct(AccountUser_Model $model)
    {
        parent::__construct($model);
    }
}
