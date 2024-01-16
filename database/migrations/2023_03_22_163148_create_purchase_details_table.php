<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('purchases');
            $table->integer('item_id')->index();
            $table->float('quantity');
            $table->float('purchase_rate');
            $table->float('discount_percent')->default(0);
            $table->float('discount_amount')->default(0);
            $table->float('total_amount')->default(0);
            $table->string('converter_name', 20)->nullable();
            $table->float('convert_quantity')->default(0);
            $table->text('remark')->nullable();
            $table->enum('use_for', ['Medicine', 'Instrument'])->default('Medicine')->index();
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
        Schema::dropIfExists('purchase_details');
    }
}
