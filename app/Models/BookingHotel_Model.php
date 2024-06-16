<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingHotel_Model extends Model
{
    use HasFactory;
    protected $table = 'bookinghotel';
    protected $primary = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'GuestId',
        'RoomId',
        'ConfirmBy',
        'CreateDate',
        'Price',
        'Gift',
        'Discount',
        'State',
        'Notes',
        'TimeRecive',
        'TimeLeave',
        'ConfirmAt',
        'created_at',
        'updated_at',
        'GiftCode',
        'GiftCodePrice',
        'VAT',
        'TypePay'
    ];
    public function memberbookhotel()
    {
        return $this->hasMany(Guest_Model::class, 'BookHotelId', 'id');
    }
    public function room()
    {
        return $this->hasOne(Room_Model::class, 'id', 'RoomId');
    }
}
