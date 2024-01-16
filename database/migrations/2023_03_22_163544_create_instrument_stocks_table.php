<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumentStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instrument_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrument_id')->constrained('instruments');
            $table->float('purchase_quantity')->default(0);
            $table->float('purchase_return_quantity')->default(0);
            $table->float('issue_quantity')->default(0);
            $table->float('issue_return_quantity')->default(0);
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
        Schema::dropIfExists('instrument_stocks');
    }
}
