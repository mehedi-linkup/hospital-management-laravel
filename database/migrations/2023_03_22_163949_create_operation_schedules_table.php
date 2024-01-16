<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operation_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('schedule_code', 20)->unique();
            $table->foreignId('doctor_id')->constrained('doctors');
            $table->foreignId('room_id')->constrained('rooms');
            $table->foreignId('bed_id')->constrained('beds');
            $table->foreignId('patient_id')->constrained('patients');
            $table->date('bill_date')->index();
            $table->dateTime('time_from')->index();
            $table->dateTime('time_to')->index();
            $table->float('amount');
            $table->text('remark')->nullable();
            $table->boolean('is_done')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('ip_address', 100)->nullable();
            $table->char('status', 2)->default('a')->comment('a=active, d=deactive')->index();
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
        Schema::dropIfExists('operation_schedules');
    }
}
