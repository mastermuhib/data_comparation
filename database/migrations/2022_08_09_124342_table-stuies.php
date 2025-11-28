<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableStuies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('table_studies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('study_name')->nullable();
            $table->text('description')->nullable();
            $table->date('deleted_at')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
         DB::statement('ALTER TABLE table_studies ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_studies');
    }
}
