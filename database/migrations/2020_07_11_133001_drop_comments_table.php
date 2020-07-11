<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropCommentsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('comments');
    }
}
