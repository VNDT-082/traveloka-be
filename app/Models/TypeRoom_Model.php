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
}
