<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinishedProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finished_product_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quantity');
            $table->string('validity');
            $table->unsignedBigInteger('finished_product_stock_id')->nullable();
            $table->unsignedBigInteger('production_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finished_product_stocks');
    }
}
