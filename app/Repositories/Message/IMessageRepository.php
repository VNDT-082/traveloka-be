<?php

namespace App\Repositories\Message;

use App\Repositories\IBaseRepository;

interface IMessageRepository extends IBaseRepository
{
    public function getAllbyUserId($id);
}
