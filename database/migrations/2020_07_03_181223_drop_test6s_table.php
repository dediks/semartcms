<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropTest6sTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('test6s');
    }
}
