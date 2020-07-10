<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Services\BookService;
use Requests\{
	BookCreateRequest,
	BookUpdateRequest
};

class BookController extends Controller
{
	private $bookService;

	public function __construct(BookService $book)
	{
		$this->bookService = $book;

		$this->middleware(function ($request, $next) {
			if (Gate::allows('show-this',  $this->bookService->getTableName())) return $next($request);

			abort(403, 'Anda tidak memiliki cukup hak akses');
		});
	}

	public function index()
	{
		$books = $this->bookService->paginate(10);

		return view('books.index', compact('books'));
	}

	public function create()
	{
		return view('books.create');
	}

	public function store(BookCreateRequest $request)
	{
		$create = $this->bookService->create($request);
		flash('{Module} created successfully')->success();

		return redirect('books');
	}

	public function edit($id)
	{
		$book = $this->bookService->find($id);

		return view('books.edit', compact('book', 'id'));
	}

	public function update(BookUpdateRequest $request, $id)
	{
		$book = $this->bookService->findAndUpdate($request, $id);

		flash('{Module} updated successfully')->success();

		return redirect('books');
	}

	public function destroy($id)
	{
		$this->bookService->destroy($id);

		flash('{Module} deleted successfully')->success();

		return redirect('books');
	}
}
