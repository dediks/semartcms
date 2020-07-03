<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropTes4sTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tes4s');
    }
}
