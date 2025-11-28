<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SickCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('medical_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('category_name')->nullable();
            $table->text('description')->nullable();
            $table->date('deleted_at')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
         DB::statement('ALTER TABLE medical_categories ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_categories');
    }
}
