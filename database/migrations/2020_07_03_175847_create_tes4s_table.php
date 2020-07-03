<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTes4sTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tes4s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file2');
            $table->string('field_name');
            $table->string('file1');
            
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
        Schema::drop('tes4s');
    }
}
