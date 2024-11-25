<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    use HasFactory;

    public function user() { 
        return $this-> belongsTo(Employee::class, 'emp_dept', 'code');
    }

    protected $fillable = [ 
        'code', 'dept', 'logo'
    ];
}
