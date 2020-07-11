<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropCobasTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('cobas');
    }
}
