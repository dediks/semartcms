<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Services\BooksService;
use Illuminate\Support\Facades\Gate;
use Requests\{
	BooksCreateRequest,
	BooksUpdateRequest
};

class BooksController extends Controller
{
	private $booksService;

	public function __construct(BooksService $books)
	{
		$this->booksService = $books;

		$this->middleware(function ($request, $next) {
			if (Gate::allows('show-this',  $this->booksService->getTableName())) return $next($request);

			abort(403, 'Anda tidak memiliki cukup hak akses');
		});
	}

	public function index()
	{
		$books = $this->booksService->paginate(10);

		return view('books.index', compact('books'));
	}

	public function create()
	{
		return view('books.create');
	}

	public function store(BooksCreateRequest $request)
	{
		$create = $this->booksService->create($request);
		flash('{Module} created successfully')->success();

		return redirect('books');
	}

	public function edit($id)
	{
		$books = $this->booksService->find($id);

		return view('books.edit', compact('books', 'id'));
	}

	public function update(BooksUpdateRequest $request, $id)
	{
		$books = $this->booksService->findAndUpdate($request, $id);

		flash('{Module} updated successfully')->success();

		return redirect('books');
	}

	public function destroy($id)
	{
		$this->booksService->destroy($id);

		flash('{Module} deleted successfully')->success();

		return redirect('books');
	}
}
