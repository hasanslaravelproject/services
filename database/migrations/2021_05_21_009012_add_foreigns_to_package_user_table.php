<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToPackageUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_user', function (Blueprint $table) {
            $table
                ->foreign('package_id')
                ->references('id')
                ->on('packages');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_user', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            $table->dropForeign(['user_id']);
        });
    }
}
