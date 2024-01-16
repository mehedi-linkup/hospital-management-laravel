<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->string('admission_code', 50)->unique();
            $table->date('admission_date')->index();
            $table->time('admission_time')->nullable();
            $table->date('bed_release_date')->nullable();
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('doctor_id')->constrained('doctors');
            $table->integer('reference_id')->nullable();
            $table->foreignId('room_id')->constrained('rooms');
            $table->foreignId('bed_id')->constrained('beds');
            $table->float('admission_fees');
            $table->float('bed_rent');
            $table->float('received_amount');
            $table->text('remark')->nullable(); 
            $table->boolean('is_shift')->default(0);
            $table->char('status', 20)->default('Admited')->index();
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
        Schema::dropIfExists('admissions');
    }
}
