<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableAdministrators extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('administrators', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_role')->nullable();
            $table->string('admin_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('profile')->nullable();
            $table->string('password')->nullable();
            $table->string('confirm_password')->nullable();
            $table->integer('status')->default(1);
            $table->text('address')->nullable();
            $table->timestamps();
        });
         DB::statement('ALTER TABLE administrators ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrators');
    }
}
