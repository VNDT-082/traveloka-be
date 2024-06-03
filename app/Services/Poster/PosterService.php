<?php

namespace App\Services\Poster;

use App\Repositories\Poster\IPosterRepository;
use App\Services\BaseService;

class PosterService extends BaseService implements IPosterService
{
    protected $repository;
    public function __construct(IPosterRepository $repository)
    {
        parent::__construct($repository);
    }
    public function getOneById($id)
    {
        return $this->repository->getOneById($id);
    }
    public function getOneByGitCode($giftCode)
    {
        return $this->repository->getOneByGitCode($giftCode);
    }
}
