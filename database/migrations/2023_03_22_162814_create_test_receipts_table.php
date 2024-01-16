<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 20)->unique();
            $table->date('bill_date')->index();
            $table->foreignId('patient_id')->constrained('patients');
            $table->integer('admission_id')->nullable();
            $table->integer('reference_id')->nullable();
            $table->float('subtotal');
            $table->float('vat_percent');
            $table->float('vat_amount');
            $table->float('discount_percent');
            $table->float('discount_amount');
            $table->float('others')->default(0);
            $table->float('total');
            $table->float('paid');
            $table->float('due');
            $table->boolean('is_completed')->default(false);
            $table->boolean('is_delivered')->default(false);
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
        Schema::dropIfExists('test_receipts');
    }
}
