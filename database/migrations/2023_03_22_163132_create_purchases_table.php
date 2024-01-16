<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 20)->unique();
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->date('order_date')->index();
            $table->float('subtotal');
            $table->float('discount_percent');
            $table->float('discount_amount');
            $table->float('vat_percent');
            $table->float('vat_amount');
            $table->float('transport_cost');
            $table->float('total');
            $table->float('paid');
            $table->float('due');
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
        Schema::dropIfExists('purchases');
    }
}
