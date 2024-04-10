<?php

namespace App\Repositories\AccountUser;


use App\Models\User;
use App\Repositories\BaseRepository;

class AccountUserRepository extends BaseRepository implements IAccountUserRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
