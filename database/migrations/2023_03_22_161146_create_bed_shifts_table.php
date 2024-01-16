<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBedShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bed_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admission_id')->constrained('admissions');
            $table->foreignId('patient_id')->constrained('patients');
            $table->date('shift_date')->index();
            $table->time('shift_time')->nullable();
            $table->date('bed_release_date')->nullable();
            $table->foreignId('from_room_id')->constrained('rooms');
            $table->foreignId('from_bed_id')->constrained('beds');
            $table->foreignId('to_room_id')->constrained('rooms');
            $table->foreignId('to_bed_id')->constrained('beds');
            $table->float('bed_rent');
            $table->boolean('is_shift')->default(0);
            $table->text('remark')->nullable(); 
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('ip_address', 100)->nullable();
            $table->integer('branch_id')->default(1)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bed_shifts');
    }
}
