<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SchollTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('table_scholls', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('image')->nullable();
            $table->string('scholl_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('id_province')->nullable();
            $table->integer('id_city')->nullable();
            $table->bigInteger('id_district')->nullable();
            $table->string('address')->nullable();
            $table->string('pos_code')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->date('deleted_at')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
         DB::statement('ALTER TABLE table_scholls ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_scholls');
    }
}
