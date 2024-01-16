<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number', 20)->unique();
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->date('payment_date')->index();
            $table->enum('transaction_type', ['Payment', 'Received'])->default('Payment')->index();      
            $table->enum('payment_type', ['Cash', 'Bank'])->default('Cash')->index();  
            $table->integer('account_id')->nullable()->index();    
            $table->float('amount');
            $table->float('previous_due');
            $table->text('remark')->nullable();
            $table->enum('use_for', ['Medicine', 'Instrument'])->default('Medicine')->index();
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
        Schema::dropIfExists('supplier_payments');
    }
}
