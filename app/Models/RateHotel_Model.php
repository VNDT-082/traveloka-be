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
    protected $fillable = [
        'id', 'HotelId', 'GuestId', 'Rating', 'Description', 'Sach_Se',
        'Thoai_Mai', 'Dich_Vu', 'HinhAnh', 'created_at', 'updated_at'
    ];
    public function guest()
    {
        return $this->BelongsTo(Guest_Model::class, 'GuestId', 'id');
    }
    public function hotel()
    {
        return $this->belongsTo(Hotel_Model::class, 'HotelId', 'id');
    }
}
