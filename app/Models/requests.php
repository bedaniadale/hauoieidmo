<?php

namespace App\Models;


use App\Models\respub as ModelsRespub;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class requests extends Model
{
    use HasFactory;

    

    public function user() { 
        return $this-> hasOne(Employee::class, 'emp_id', 'emp_id');
    }

    public function employment() { 
        return $this-> hasOne(Employment::class, 'id', 'id'); 
    }

    public function license() { 
        return $this-> hasOne(Licenses::class, 'id','id');
    }

    public function training() { 
        return $this->hasOne(Trainings::class, 'id','id'); 
    }

    public function certifications()
    {
        return $this->hasOne(certifications::class, 'id', 'id');
    
    }


    public function modelrespub() { 
        return $this-> hasOne(ModelsRespub::class, 'id','id'); 
    }

    protected $table = 'requests'; 

    public $timestamps = false;
    

    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 
        'emp_id', //category id (ex: respub-20421990)
        'title',
        'type', 
        'date_submitted',


    ]; 

    protected $casts = [
        'id'=> 'string'
    ];
}
