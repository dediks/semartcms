<?php

namespace App;
use App\Traits\CommentTrait;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	use CommentTrait;

	protected $table = 'comments';
	protected $guarded  = [];
}
