<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableVillages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('villages', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('district_id')->nullable();
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
        Schema::dropIfExists('villages');
    }
}
