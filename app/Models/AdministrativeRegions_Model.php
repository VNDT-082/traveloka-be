<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministrativeRegions_Model extends Model
{
    use HasFactory;
    protected $table = 'administrative_regions';
    protected $primary = 'id';
    public $incrementing = false;
}
