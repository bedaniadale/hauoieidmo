<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loads extends Model
{


    public function user() { 
        return $this-> hasOne(Employee::class, 'emp_id', 'emp_id'); 
    }
    public function subject()
    {
        return $this->hasOne(Subjects::class, 'subj_id', 'subj_id');
    
    }


    use HasFactory;

    protected $table = 'loads'; 
    protected $fillable = [
        'emp_id', 'subj_id', 'class_code',  'created_at', 'updated_at', 'semester', 'sy', 'created_at','added_by'
    ]; 

}
