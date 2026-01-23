<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TotalRecapVillages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('t_recaps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_clasification')->nullable();
            $table->bigInteger('id_district')->nullable();
            $table->bigInteger('total_male')->nullable();
            $table->bigInteger('total_female')->nullable();
            $table->integer('triwulan')->nullable();
            $table->integer('year')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE t_recaps ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_recaps');
    }
}
