<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{

    public function login() { 
        return $this-> hasOne(Employee_Login::class, 'id' , 'emp_id' );
    }

    public function department() { 
        return $this-> hasOne(Departments::class, 'code', 'emp_dept'); 
    }
    
    public function provincial_contact() 
    { 
        return $this->hasOne(provincial_contact::class, 'id', 'emp_id');
    }

    public function dependencies() { 
        return $this->hasMany(dependencies::class, 'emp_id', 'emp_id'); 
    }

    public function emergency_contact() { 
        return $this-> hasOne(emergency::class, 'emp_id', 'emp_id'); 
    }

    public function accounting_details(){ 
        return $this-> hasOne(acc_details::class, 'emp_id', 'emp_id');
    }

    
    public function orgs()  { 
        return $this -> hasMany(orgs::class,'emp_id', 'emp_id'); 
    }

    public function certification() { 
        return $this->hasMany(certifications::class, 'emp_id', 'emp_id'); 
    }

    public function hiring() { 
        return $this->hasOne(HiringInfo::class, 'emp_id', 'emp_id'); 
    }

    public function loadsimport() { 
        return $this->hasMany(LoadsImport::class, 'emp_id', 'emp_id');
    }

    //// belongs toooooooooooo

    public function loads() { 
        return $this-> belongsTo(Loads::class, 'emp_id', 'emp_id');
    }

    
    public function request() { 
        return $this-> belongsTo(requests::class, 'emp_id', 'emp_id'); 
    }

    public function queue()
    {
        return $this->belongsTo(batch_queue::class, 'emp_id', 'emp_id');

    }
    protected $table = 'tbl_info'; 
    protected $primaryKey = 'emp_id'; 
    protected $fillable = [
        'emp_id',
        'emp_fname',
        'emp_mname',
        'emp_lname',
        'emp_dept',
        'emp_gender',
        'emp_maiden_name',
        'emp_dob',
        'emp_pob',
        'emp_cStatus',
        'emp_religion',
        'emp_blood_type',
        'emp_houseno',
        'street',
        'brgy',
        'city',
        'province',
        'postal_code',
        'profile_picture',
        'info_status',
        'home_phone',
        'mobile_phone',
        'email_address_1',
        'email_address_2',

        'emp_position', 
        'emp_nature', 
        'emp_tenure', 
        'non_tenured',
        'emp_division',
        'emp_type',//full time or part time 
    
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */


    protected $dates = [
        'emp_dob'
    ];
    protected $casts = [
        'emp_id'=> 'string', 
        'emp_dob' => 'date',
    ];
}
