<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room_Model extends Model
{
    use HasFactory;
    protected $table = 'room';
    protected $primary = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'TypeRoomId',
        'State',
        'TimeRecive',
        'TimeLeave',
        'Gift',
        'Discount',
        'Breakfast',
        'Wifi',
        'NoMoking',
        'Cancel',
        'ChangeTimeRecive',
        'RoomName',
        'Hinh_Thuc_Thanh_Toan',
        'Bao_Gom_Thue_Va_Phi',
        'created_at',
        'updated_at'
    ];
    public function typeroom()
    {
        return $this->belongsTo(TypeRoom_Model::class, 'TypeRoomId', 'id');
    }
}
