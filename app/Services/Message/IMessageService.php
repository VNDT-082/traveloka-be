<?php

namespace App\Services\Message;

use App\Services\IBaseService;

interface IMessageService extends IBaseService
{
    public function getAllbyUserId($id);
}
