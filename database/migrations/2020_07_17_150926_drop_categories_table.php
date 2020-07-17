<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropCategoriesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('categories');
    }
}
