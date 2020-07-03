<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropTestsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tests');
    }
}
