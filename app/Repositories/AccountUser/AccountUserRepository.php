<?php

namespace App\Repositories\AccountUser;

use App\Models\AccountUser_Model;
use App\Repositories\BaseRepository;

class AccountUserRepository extends BaseRepository implements IAccountUserRepository
{
    public function __construct(AccountUser_Model $model)
    {
        parent::__construct($model);
    }
}
