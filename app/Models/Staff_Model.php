<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff_Model extends Model
{
    use HasFactory;
    protected $table = 'staff';
    protected $primary = 'id';
    public $incrementing = false;
}
