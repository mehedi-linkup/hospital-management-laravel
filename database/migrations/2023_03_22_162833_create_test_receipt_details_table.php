<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestReceiptDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_receipt_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_receipt_id')->constrained('test_receipts');
            $table->foreignId('test_id')->constrained('tests');
            $table->date('delivery_date')->index();
            $table->time('delivery_time')->nullable();
            $table->float('amount');
            $table->boolean('is_completed')->default(false);
            $table->boolean('is_delivered')->default(false);
            $table->longText('report')->nullable(); 
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
        Schema::dropIfExists('test_receipt_details');
    }
}
