<?php

use App\Models\Hotel_Model;

class Hotel_Repository extends BaseRepository implements IHotel_Repository
{
    public function __construct(Hotel_Model $model)
    {
        parent::__construct($model);
    }
}
