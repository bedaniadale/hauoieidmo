<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('tbl_provincial_contact', function (Blueprint $table) { 
            //pc - Provincial Contact 
            $table->integer('id')-> primary(); 
        $table->  string('pc_emp_houseno', 50)-> nullable(); 
            $table-> string('pc_street', 20) -> nullable();
            $table-> string('pc_brgy', 50 )-> nullable(); 
            $table-> string('pc_city', 50)-> nullable(); 
            $table -> string('pc_province', 50)-> nullable();  
            $table-> integer('pc_postal_code')-> nullable();
            $table-> string('pc_phone')->nullable(); 
            $table-> timestamps(); 
        });


        Schema::create('tbl_emergency', function (Blueprint $table) {
            $table->integer('emp_id')-> primary();
            //contact person - cp
            $table->string('cp_fname')->nullable(); 
            $table->string('cp_mname')->nullable(); 
            $table->string('cp_lname')->nullable(); 
            $table->string('cp_relationship')->nullable(); 
            $table->string('cp_house_no')->nullable(); 
            $table-> string('cp_street', 20) -> nullable();
            $table-> string('cp_brgy', 50 )-> nullable(); 
            $table-> string('cp_city', 50)-> nullable(); 
            $table -> string('cp_province', 50)-> nullable();  
            $table-> integer('cp_postal_code')-> nullable();
            $table->string('cp_home_phone')->nullable() ; 
            $table-> string('cp_mobile_no')-> nullable(); 
            $table->timestamps();
        });




    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('tbl_provincial_contact'); 
        Schema::dropIfExists('tbl_emergency'); 
    }
};
