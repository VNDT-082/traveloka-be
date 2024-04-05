<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message_Model extends Model
{
    use HasFactory;
    protected $table = 'message';
    protected $primary = 'id';
}
