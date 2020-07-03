<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTest6sTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test6s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sas');
            $table->string('sasa');
            
            $table->unsignedBigInteger('project_id');
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
        Schema::drop('test6s');
    }
}
