<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class respub extends Model
{
    use HasFactory;

    public function request()
    {
        return $this->belongsTo(requests::class, 'id', 'id');

    }
    

    protected $table = 'respub'; 
    protected $primaryKey = 'id' ;

    protected $fillable = [
        'id','type','emp_id','title','description','attachment','date_published','status','created_at','updated_at'];



        protected $casts = [
            'id' => 'string', // Ensure 'id' is cast to string
        ];
        
}
