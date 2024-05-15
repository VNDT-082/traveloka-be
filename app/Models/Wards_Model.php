<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wards_Model extends Model
{
    use HasFactory;
    protected $table = 'wards';
    protected $primary = 'code';
    public $incrementing = false;
}
