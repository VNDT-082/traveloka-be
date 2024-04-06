<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateHotel_Model extends Model
{
    use HasFactory;
    protected $table = 'ratehotel';
    protected $primary = 'id';
    public $incrementing = false;
}
