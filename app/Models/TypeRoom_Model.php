<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeRoom_Model extends Model
{
    use HasFactory;
    protected $table = 'typeroom';
    protected $primary = 'id';
    public $incrementing = false;
    public function hotel()
    {
        return $this->belongsTo(Hotel_Model::class, 'HotelId', 'id');
    }
    public function room()
    {
        return $this->hasMany(Room_Model::class, 'TypeRoomId', 'id');
    }
}
