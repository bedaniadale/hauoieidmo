<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HiringHistory extends Model
{
    protected $fillable = [
        'id',
        'emp_id',
        'date',
        'position',
        'division',
        'department',
        'nature',
    ];
    
}
