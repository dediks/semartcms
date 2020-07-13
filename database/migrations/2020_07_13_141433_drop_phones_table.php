<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropPhonesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('phones');
    }
}
