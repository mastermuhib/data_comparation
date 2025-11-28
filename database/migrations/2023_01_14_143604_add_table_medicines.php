<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableMedicines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('table_medicines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('medicine')->nullable();
            $table->string('icon')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
         DB::statement('ALTER TABLE table_medicines ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_medicines');
    }
}
