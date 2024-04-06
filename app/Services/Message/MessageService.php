<?php

namespace App\Services\Message;

use App\Models\Message_Model;
use App\Services\BaseService;

class MessageService extends BaseService implements IMessageService
{
    public function __construct(Message_Model $model)
    {
        parent::__construct($model);
    }
}