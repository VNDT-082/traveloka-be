<?php

namespace App\Repositories\Guest;

use App\Repositories\IBaseRepository;

interface IGuestRepository extends IBaseRepository
{
    public function getOneByEmail(string $email);
    public function getOneById(string $id);
}
