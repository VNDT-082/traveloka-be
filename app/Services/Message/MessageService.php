<?php

namespace App\Services\Message;

use App\Models\Message_Model;
use App\Repositories\Message\IMessageRepository;
use App\Services\BaseService;

class MessageService extends BaseService implements IMessageService
{
    protected $repository;
    public function __construct(IMessageRepository $repository)
    {
        parent::__construct($repository);
    }
    public function getAllbyUserId($id)
    {
        return $this->repository->getAllbyUserId($id);
    }
}
