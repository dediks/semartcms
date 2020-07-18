<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropBlogPostsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('blog_posts');
    }
}
