<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room_Model extends Model
{
    use HasFactory;
    protected $table = 'room';
    protected $primary = 'id';
    public $incrementing = false;
}
