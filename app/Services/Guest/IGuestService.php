<?php

namespace App\Services\Guest;

use App\Services\IBaseService;

interface IGuestService extends IBaseService
{
    public function getOneByEmail(string $email);
    public function getOneById(string $id);
}
