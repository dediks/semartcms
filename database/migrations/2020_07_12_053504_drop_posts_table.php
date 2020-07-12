<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropPostsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('posts');
    }
}
