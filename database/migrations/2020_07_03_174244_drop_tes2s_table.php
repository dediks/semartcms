<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropTes2sTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tes2s');
    }
}
