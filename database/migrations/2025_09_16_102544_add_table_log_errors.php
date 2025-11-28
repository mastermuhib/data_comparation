<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableLogErrors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('log_errors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('controller')->nullable();
            $table->string('line_error')->nullable();
            $table->text('exception')->nullable();
            $table->integer('type')->nullable();
            $table->uuid('id_user')->nullable();
            $table->integer('is_view')->default(0);
            $table->integer('is_solved')->default(0); 
            $table->timestamp('failed_at')->nullable();           
            $table->timestamps();
        });
         DB::statement('ALTER TABLE log_errors ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_errors');
    }
}
