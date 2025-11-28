<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableCountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('countries', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('name')->nullable();                  
            $table->integer('status')->default(0);
            $table->float('latitude')->nullable(); 
            $table->float('longitude')->nullable();
            $table->timestamp('deleted_at')->nullable();           
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
        Schema::dropIfExists('countries');
    }
}
