<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyHotel_Model extends Model
{
    use HasFactory;
    protected $table = 'policyhotel';
    protected $primary = 'id';
    public $incrementing = false;
}
