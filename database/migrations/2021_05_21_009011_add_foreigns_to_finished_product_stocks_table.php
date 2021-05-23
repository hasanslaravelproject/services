<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToFinishedProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finished_product_stocks', function (Blueprint $table) {
            $table
                ->foreign('finished_product_stock_id')
                ->references('id')
                ->on('finished_product_stocks');

            $table
                ->foreign('production_id')
                ->references('id')
                ->on('productions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finished_product_stocks', function (Blueprint $table) {
            $table->dropForeign(['finished_product_stock_id']);
            $table->dropForeign(['production_id']);
        });
    }
}
