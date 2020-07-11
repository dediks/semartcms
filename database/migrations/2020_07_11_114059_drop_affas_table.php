<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropAFFASTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('AFFAS');
    }
}
