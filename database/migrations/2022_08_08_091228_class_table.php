<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('table_class', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('class_name')->nullable();
            $table->uuid('id_scholl')->nullable();
            $table->string('description')->nullable();
            $table->integer('capacity')->default(1);
            $table->timestamps();
        });
        DB::statement('ALTER TABLE table_class ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_class');
    }
}
