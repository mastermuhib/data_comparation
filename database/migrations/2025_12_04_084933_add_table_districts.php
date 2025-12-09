<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableDistricts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('districts', function (Blueprint $table) {
            $table->bigInteger('id')->primary();            
            $table->string('name')->nullable();               
            $table->bigInteger('male_dpt')->default(0); 
            $table->bigInteger('female_dpt')->default(0);  
            $table->bigInteger('total_dpt')->default(0);                  
            $table->timestamps();
        });
         
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('districts');
    }
}
