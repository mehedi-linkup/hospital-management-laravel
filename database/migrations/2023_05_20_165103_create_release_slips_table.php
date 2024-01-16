<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleaseSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('release_slips', function (Blueprint $table) {
            $table->id();
            $table->string('releaseslip_code', 50)->unique();
            $table->date('slip_date')->index();
            $table->time('slip_time')->index()->nullable();
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('doctor_id')->constrained('doctors');
            $table->foreignId('admission_id')->constrained('admissions');
            $table->foreignId('room_id')->constrained('rooms');
            $table->foreignId('bed_id')->constrained('beds');
            $table->float('admission_fees')->default(0);
            $table->float('bills_amount')->default(0);
            $table->float('pathology_amount')->default(0);
            $table->float('pharmacy_amount')->default(0);
            $table->float('hospital_amount')->default(0);
            $table->float('ot_amount')->default(0);
            $table->float('due');
            $table->float('previous_paid');
            $table->float('discount');
            $table->float('amount')->default(0);
            $table->text('remark')->nullable(); 
            $table->char('status', 20)->default('Release')->index();
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
        Schema::dropIfExists('release_slips');
    }
}
