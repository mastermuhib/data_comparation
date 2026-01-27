<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableSteps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('t_steps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->tinyInteger('month')->nullable();
            $table->integer('year')->nullable();
            $table->integer('triwulan')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_klasifikasi')->default(0);
            $table->tinyInteger('is_disabilitas')->default(0);
            $table->timestamps();
        });
        DB::statement('ALTER TABLE t_steps ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_steps');
    }
}
