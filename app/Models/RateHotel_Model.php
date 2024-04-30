<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RateHotel_Model extends Model
{
    use HasFactory;
    protected $table = 'ratehotel';
    protected $primary = 'id';
    public $incrementing = false;
    public function guest()
    {
        return $this->BelongsTo(Guest_Model::class, 'GuestId', 'id');
    }
    public function hotel()
    {
        return $this->belongsTo(Hotel_Model::class, 'HotelId', 'id');
    }
}
