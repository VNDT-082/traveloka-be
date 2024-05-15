<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministrativeUnits_Model extends Model
{
    use HasFactory;
    protected $table = 'administrative_units';
    protected $primary = 'id';
    public $incrementing = false;
}
