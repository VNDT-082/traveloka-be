<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest_Model extends Model
{
    use HasFactory;
    protected $table = 'guest';
    protected $primary = 'id';
}
