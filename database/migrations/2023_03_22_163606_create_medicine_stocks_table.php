<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicineStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicine_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicine_id')->constrained('medicines');
            $table->float('purchase_quantity')->default(0);
            $table->float('purchase_return_quantity')->default(0);
            $table->float('sales_quantity')->default(0);
            $table->float('sales_return_quantity')->default(0);
            $table->float('damage_quantity')->default(0);
            $table->float('stock_quantity')->default(0);
            $table->timestamps();
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
        Schema::dropIfExists('medicine_stocks');
    }
}
