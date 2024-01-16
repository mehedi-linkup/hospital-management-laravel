<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbulanceBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambulance_bills', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 20)->unique();
            $table->foreignId('driver_id')->constrained('drivers');
            $table->foreignId('ambulance_id')->constrained('ambulances');
            $table->foreignId('patient_id')->constrained('patients');
            $table->date('bill_date')->index();
            $table->float('bill_amount');
            $table->float('paid');
            $table->float('due');
            $table->text('destination')->nullable();
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('ambulance_bills');
    }
}
