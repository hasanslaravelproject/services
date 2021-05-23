<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRawProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raw_product_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quantity');
            $table->dateTime('expiry_date');
            $table->unsignedBigInteger('ingredient_id')->nullable();

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
        Schema::dropIfExists('raw_product_stocks');
    }
}
