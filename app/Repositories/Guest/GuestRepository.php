<?php

namespace App\Repositories\Guest;

use App\Models\Guest_Model;
use App\Repositories\BaseRepository;

class GuestRepository extends BaseRepository implements IGuestRepository
{
    public function __construct(Guest_Model $model)
    {
        parent::__construct($model);
    }
    public function getOneByEmail(string $email)
    {
        //return $this->model::where('Email', '=', $email)->first();
        $guest = $this->model::leftJoin('users as u', 'u.id', '=', 'UserAccountId')
            ->select(
                'guest.id',
                'guest.UserAccountId',
                'guest.Email',
                'guest.Telephone',
                'guest.Name',
                'guest.Sex',
                'guest.Type',
                'guest.Avarta',
                'guest.DateOfBirth',
                'guest.IsActive',
                'guest.created_at',
                'guest.updated_at',
                'u.email as EmailContact',
                'u.Telephone as TelephoneContact'
            )
            ->where('u.email', '=', $email)
            ->first();
        return $guest;
    }
}
