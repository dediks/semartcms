<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBooktestCategoryTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('booktest_category')) {
            Schema::create('booktest_category', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('booktest_id');
                $table->unsignedBigInteger('category_id');
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
        Schema::drop('booktest_category');
    }
}
