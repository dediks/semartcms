<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropOrdersTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('orders');
    }
}
