<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTest2sTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('test2s')) {
            Schema::create('test2s', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('title')->nullable();
            $table->string('price')->nullable();
            $table->date('date')->nullable();
                
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
        Schema::drop('test2s');
    }
}
