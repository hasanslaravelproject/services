<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToRawProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('raw_product_stocks', function (Blueprint $table) {
            $table
                ->foreign('ingredient_id')
                ->references('id')
                ->on('ingredients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('raw_product_stocks', function (Blueprint $table) {
            $table->dropForeign(['ingredient_id']);
        });
    }
}
