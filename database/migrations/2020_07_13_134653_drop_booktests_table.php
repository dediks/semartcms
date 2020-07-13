<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropBooktestsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('booktests');
    }
}
