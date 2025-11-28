<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTablePhisicalCheckup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('physical_records', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_student')->nullable();
            $table->uuid('id_scholl')->nullable();
            $table->uuid('id_class')->nullable();
            $table->uuid('id_admin')->nullable();
            $table->uuid('id_parent')->nullable();
            $table->string('conjunctiva')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->string('pulse')->nullable();
            $table->string('hair_healthy')->nullable();
            $table->string('with_glasses_right')->nullable();
            $table->string('without_glasses_right')->nullable();
            $table->string('with_glasses_left')->nullable();
            $table->string('without_glasses_left')->nullable();
            $table->string('cockeye')->nullable();
            $table->string('eye_inflammation')->nullable();
            $table->string('color_blind')->nullable();
            $table->string('hearing_power_right')->nullable();
            $table->string('hearing_power_left')->nullable();
            $table->string('ear_wax_right')->nullable();
            $table->string('ear_wax_left')->nullable();
            $table->string('nasal_abnormalities')->nullable();
            $table->string('throat')->nullable();
            $table->string('mouth_teeth')->nullable();
            $table->string('chest_cough')->nullable();
            $table->string('heart')->nullable();
            $table->string('lungs')->nullable();
            $table->string('liver')->nullable();
            $table->string('spleen')->nullable();
            $table->string('tenderness')->nullable();
            $table->string('motion_members')->nullable();
            $table->string('skin')->nullable();
            $table->text('diagnose')->nullable();
            $table->text('conclusion')->nullable();
            $table->string('weight_result')->nullable();
            $table->string('height_result')->nullable();
            $table->string('teeth_result')->nullable();
            $table->string('eye_result')->nullable();
            $table->string('nasal_result')->nullable();
            $table->string('mouth_result')->nullable();
            $table->string('nutrition_result')->nullable();
            $table->string('body_result')->nullable();
            $table->string('skin_result')->nullable();
            $table->string('signature_parent')->nullable();
            $table->timestamp('date')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
         DB::statement('ALTER TABLE physical_records ALTER COLUMN id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('physical_records');
    }
}
