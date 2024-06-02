<?php

namespace App\Services\Guest;

use App\Models\Guest_Model;
use App\Repositories\Guest\IGuestRepository;
use App\Services\BaseService;

class GuestService extends BaseService implements IGuestService
{
    protected $repository;
    public function __construct(IGuestRepository $repository)
    {
        parent::__construct($repository);
    }
    public function getOneByEmail(string $email)
    {
        return $this->repository->getOneByEmail($email);
    }
    public function getOneById(string $id)
    {
        return $this->repository->getOneById($id);
    }
}
