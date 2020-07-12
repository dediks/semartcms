<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropAuithorsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('auithors');
    }
}
