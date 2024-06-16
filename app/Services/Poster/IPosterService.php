<?php

namespace App\Services\Poster;

use App\Services\IBaseService;

interface IPosterService extends IBaseService
{
    public function getOneById($id);
    public function getOneByGitCode($giftCode);
    public function getAllHaveGitCode();
}
