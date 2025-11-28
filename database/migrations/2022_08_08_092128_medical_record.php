<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('medical_records', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_student')->nullable();
            $table->uuid('id_category')->nullable();
            $table->uuid('id_class')->nullable();
            $table->timestamp('record_date')->nullable();
            $table->text('problem')->nullable();
            $table->text('solving')->nullable();
            $table->date('deleted_at')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
         DB::statement('ALTER TABLE medical_records ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_records');
    }
}
