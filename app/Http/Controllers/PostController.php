<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Services\PostService;
use Illuminate\Support\Facades\Gate;
use Requests\{
	PostCreateRequest,
	PostUpdateRequest
};

class PostController extends Controller
{
	private $postService;

	public function __construct(PostService $post)
	{
		$this->postService = $post;

		$this->middleware(function ($request, $next) {
			if (Gate::allows('show-this',  $this->postService->getTableName())) return $next($request);

			abort(403, 'Anda tidak memiliki cukup hak akses');
		});
	}

	public function index()
	{
		$posts = $this->postService->paginate(10);

		return view('posts.index', compact('posts'));
	}

	public function create()
	{
		return view('posts.create');
	}

	public function store(PostCreateRequest $request)
	{
		$create = $this->postService->create($request);
		flash('{Module} created successfully')->success();

		return redirect('posts');
	}

	public function edit($id)
	{
		$post = $this->postService->find($id);

		return view('posts.edit', compact('post', 'id'));
	}

	public function update(PostUpdateRequest $request, $id)
	{
		$post = $this->postService->findAndUpdate($request, $id);

		flash('{Module} updated successfully')->success();

		return redirect('posts');
	}

	public function destroy($id)
	{
		$this->postService->destroy($id);

		flash('{Module} deleted successfully')->success();

		return redirect('posts');
	}
}
