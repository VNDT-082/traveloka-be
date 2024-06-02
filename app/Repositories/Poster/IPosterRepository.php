<?php

namespace App\Repositories\Poster;

use App\Repositories\IBaseRepository;

interface IPosterRepository extends IBaseRepository
{
    public function getOneById($id);
    public function getOneByGitCode($giftCode);
}
