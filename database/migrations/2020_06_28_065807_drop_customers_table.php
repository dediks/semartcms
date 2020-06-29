<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropCustomersTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('Customers');
    }
}
