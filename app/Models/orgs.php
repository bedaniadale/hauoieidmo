<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orgs extends Model
{
    use HasFactory;

    public function user() { 
        return $this-> belongsTo(Employee::class, 'emp_id', 'emp_id'); 
    }


    protected $fillable = [
           'emp_id', 
           'org', //org name
           'position', 
           'date_joined', 
           'added_by'
    ];

}
