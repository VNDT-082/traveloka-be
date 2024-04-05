<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListStaff_Model extends Model
{
    use HasFactory;
    protected $table = 'liststaff';
    protected $primary = 'id';
}
