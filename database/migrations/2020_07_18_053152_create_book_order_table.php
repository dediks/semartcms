<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookOrderTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('book_order')) {
            Schema::create('book_order', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('book_id');
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
        Schema::drop('book_order');
    }
}
