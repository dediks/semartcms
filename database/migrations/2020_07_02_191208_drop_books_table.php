<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropBooksTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('books');
    }
}
