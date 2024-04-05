<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingHotel_Model extends Model
{
    use HasFactory;
    protected $table = 'bookinghotel';
    protected $primary = 'id';
}
