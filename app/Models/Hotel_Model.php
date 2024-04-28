<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel_Model extends Model
{
    use HasFactory;
    protected $table = 'hotel';
    protected $primary = 'id';
    protected $connection = 'mysql';
    public $incrementing = false;
    public function images()
    {
        return $this->hasMany(ImagesHotel_Model::class, 'HotelId', 'id');
    }
    public function convenients()
    {
        return $this->hasMany(ConvenientHotel_Model::class, 'HotelId', 'id');
    }
    public function policies()
    {
        return $this->hasMany(PolicyHotel_Model::class, 'HotelId', 'id');
    }
    public function typeRooms()
    {
        return $this->hasMany(TypeRoom_Model::class, 'HotelId', 'id');
    }

    public function rates()
    {
        return $this->hasMany(RateHotel_Model::class, 'HotelId', 'id');
    }
}
