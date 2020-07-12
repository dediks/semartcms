<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropAuthorsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('authors');
    }
}
