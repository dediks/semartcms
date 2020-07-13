<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropOrangsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('orangs');
    }
}
