<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districts_Model extends Model
{
    use HasFactory;
    protected $table = 'districts';
    protected $primary = 'code';
    public $incrementing = false;
}
