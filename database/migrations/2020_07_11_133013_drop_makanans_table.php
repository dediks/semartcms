<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropMakanansTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('makanans');
    }
}
