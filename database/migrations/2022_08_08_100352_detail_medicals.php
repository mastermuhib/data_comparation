<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DetailMedicals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('detail_medical_records', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_medical_record')->nullable();
            $table->string('medicine')->nullable();
            $table->string('dosis')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
        });
         DB::statement('ALTER TABLE detail_medical_records ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_medical_records');
    }
}
