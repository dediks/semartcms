<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropTest2sTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('test2s');
    }
}
