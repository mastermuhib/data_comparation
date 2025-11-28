<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableLogAdmins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('log_admins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('menu')->nullable();            
            $table->text('activity')->nullable();            
            $table->uuid('id_admin')->nullable();
            $table->string('mac_address')->nullable();            
            $table->timestamps();
        });
         DB::statement('ALTER TABLE log_admins ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_admins');
    }
}
