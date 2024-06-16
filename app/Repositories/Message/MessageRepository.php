<?php

namespace App\Repositories\Message;

use App\Models\Message_Model;
use App\Repositories\BaseRepository;

class MessageRepository extends BaseRepository implements IMessageRepository
{
    public function __construct(Message_Model $model)
    {
        parent::__construct($model);
    }
    public function getAllbyUserId($id)
    {
        return $this->model::where('ToHotelOrGuestId', 'like', $id)->get();
    }
}
