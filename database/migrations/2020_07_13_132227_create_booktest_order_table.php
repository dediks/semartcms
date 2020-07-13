<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBooktestOrderTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('booktest_order')) {
            Schema::create('booktest_order', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('booktest_id');
                $table->unsignedBigInteger('order_id');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('booktest_order');
    }
}
