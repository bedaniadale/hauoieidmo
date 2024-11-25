<?php

use Illuminate\Database\Eloquent\Scope;
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
        Schema::create('respub', function (Blueprint $table) {
            $table->string('id')-> primary(); 
            $table->string('type'); 
            $table->string('emp_id'); 
            $table->string('title'); 
            $table->longText('description'); 
            $table->string('file_path'); 
            $table->string('attachment'); 
            $table->date('date_published'); 
            $table ->string('status'); 
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_respub');

       
    }
};
