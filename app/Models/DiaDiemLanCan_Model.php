<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaDiemLanCan_Model extends Model
{
    use HasFactory;
    protected $table = 'diadiemlancan';
    protected $primary = 'id';
    public $incrementing = false;
}
