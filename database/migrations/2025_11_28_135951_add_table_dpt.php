<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableDpt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('t_dpt', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('dpid')->nullable();
            $table->bigInteger('id_village')->nullable();
            $table->bigInteger('id_tps')->nullable();
            $table->string('tps')->nullable();
            $table->string('nkk')->nullable();
            $table->string('nik')->nullable();
            $table->string('name')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('birth_day')->nullable();
            $table->date('birthday')->nullable();
            $table->enum('gender', ['L', 'P'])->default('L');
            $table->enum('marriage_sts', ['P', 'S', 'B'])->default('B');
            $table->text('address')->nullable();
            $table->string('disability')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->enum('ektp', ['B', 'S'])->default('B');
            $table->string('rank')->nullable();
            $table->string('source')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            $table->string('tahapan')->nullable();
            $table->string('last_update')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE t_dpt ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_dpt');
    }
}
