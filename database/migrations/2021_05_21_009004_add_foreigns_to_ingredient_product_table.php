<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToIngredientProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ingredient_product', function (Blueprint $table) {
            $table
                ->foreign('product_id')
                ->references('id')
                ->on('products');

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
        Schema::table('ingredient_product', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['ingredient_id']);
        });
    }
}
