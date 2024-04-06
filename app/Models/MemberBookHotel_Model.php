<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberBookHotel_Model extends Model
{
    use HasFactory;
    protected $table = 'memberbookhotel';
    protected $primary = 'id';
    public $incrementing = false;
}
