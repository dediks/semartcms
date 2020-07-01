<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Services\CommentService;
use Requests\{
	CommentCreateRequest,
	CommentUpdateRequest
};

class CommentController extends Controller
{
	private $commentService;

	public function __construct(CommentService $comment)
	{
		$this->commentService = $comment;
	}

	public function index()
	{
		$comments = $this->commentService->paginate(10);

		return view('comments.index', compact('comments'));
	}

	public function create()
	{
		return view('comments.create');
	}

	public function store(CommentCreateRequest $request)
	{
		$create = $this->commentService->create($request);
		flash('{Module} created successfully')->success();

		return redirect('comments');
	}

	public function edit($id)
	{
		$comment = $this->commentService->find($id);

		return view('comments.edit', compact('comment', 'id'));
	}

	public function update(CommentUpdateRequest $request, $id)
	{
		$comment = $this->commentService->findAndUpdate($request, $id);

		flash('{Module} updated successfully')->success();

		return redirect('comments');
	}

	public function destroy($id)
	{
		$this->commentService->destroy($id);

		flash('{Module} deleted successfully')->success();

		return redirect('comments');
	}
}
