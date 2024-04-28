<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poster_Model extends Model
{
    use HasFactory;
    protected $table = 'poster';
    protected $primary = 'id';
    public $incrementing = false;
}
