<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('image')->nullable();
            $table->string('student_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('id_city')->nullable();
            $table->string('address')->nullable();
            $table->string('blood_group')->nullable();
            $table->date('deleted_at')->nullable();
            $table->integer('status')->default(1);
            $table->integer('gender')->default(1);
            $table->date('birthday')->nullable();
            $table->float('weigth')->nullable();
            $table->float('heigth')->nullable();
            $table->timestamps();
        });
         DB::statement('ALTER TABLE students ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
