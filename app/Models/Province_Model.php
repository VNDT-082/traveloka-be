<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province_Model extends Model
{
    use HasFactory;
    protected $table = 'province';
    protected $primary = 'id';
    public $incrementing = false;
    public function hotel()
    {
        return $this->hasMany(Hotel_Model::class, 'HotelId', 'id');
    }
}
