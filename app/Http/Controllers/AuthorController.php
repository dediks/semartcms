<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Services\AuthorService;
use Illuminate\Support\Facades\Gate;
use Requests\{
	AuthorCreateRequest,
	AuthorUpdateRequest
};

class AuthorController extends Controller
{
	private $authorService;

	public function __construct(AuthorService $author)
	{
		$this->authorService = $author;

		$this->middleware(function ($request, $next) {
			if (Gate::allows('show-this',  $this->authorService->getTableName())) return $next($request);

			abort(403, 'Anda tidak memiliki cukup hak akses');
		});
	}

	public function index()
	{
		$authors = $this->authorService->paginate(10);

		return view('authors.index', compact('authors'));
	}

	public function create()
	{
		return view('authors.create');
	}

	public function store(AuthorCreateRequest $request)
	{
		$create = $this->authorService->create($request);
		flash('{Module} created successfully')->success();

		return redirect('authors');
	}

	public function edit($id)
	{
		$author = $this->authorService->find($id);

		return view('authors.edit', compact('author', 'id'));
	}

	public function update(AuthorUpdateRequest $request, $id)
	{
		$author = $this->authorService->findAndUpdate($request, $id);

		flash('{Module} updated successfully')->success();

		return redirect('authors');
	}

	public function destroy($id)
	{
		$this->authorService->destroy($id);

		flash('{Module} deleted successfully')->success();

		return redirect('authors');
	}
}
