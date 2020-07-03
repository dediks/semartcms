<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropTes3sTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tes3s');
    }
}
