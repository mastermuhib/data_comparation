<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudentClassRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('student_class_relations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_class')->nullable();
            $table->uuid('id_student')->nullable();
            $table->string('description')->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->integer('is_active')->default(1);
            $table->timestamps();
        });
        DB::statement('ALTER TABLE student_class_relations ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_class_relations');
    }
}
