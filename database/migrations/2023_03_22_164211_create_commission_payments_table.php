<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commission_payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number', 20)->unique();
            $table->integer('reference_id')->index();
            $table->enum('reference_type', ['Agent', 'Doctor'])->default('Agent')->index();  
            $table->date('payment_date')->index();
            $table->enum('transaction_type', ['Payment', 'Received'])->default('Payment')->index();      
            $table->enum('payment_type', ['Cash', 'Bank'])->default('Cash')->index();  
            $table->integer('account_id')->nullable()->index();    
            $table->float('amount');
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
        Schema::dropIfExists('commission_payments');
    }
}
