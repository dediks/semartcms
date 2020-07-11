<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropPaymentsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('payments');
    }
}
