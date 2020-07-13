<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Services\Book2Service;
use Illuminate\Support\Facades\Gate;
use Requests\{
	Book2CreateRequest,
	Book2UpdateRequest
};

class Book2Controller extends Controller
{
	private $book2Service;

	public function __construct(Book2Service $book2)
	{
		$this->book2Service = $book2;

		$this->middleware(function ($request, $next) {
			if (Gate::allows('show-this',  $this->book2Service->getTableName())) return $next($request);

			abort(403, 'Anda tidak memiliki cukup hak akses');
		});
	}

	public function index()
	{
		$book2s = $this->book2Service->paginate(10);

		return view('book2s.index', compact('book2s'));
	}

	public function create()
	{
		return view('book2s.create');
	}

	public function store(Book2CreateRequest $request)
	{
		$create = $this->book2Service->create($request);
		flash('{Module} created successfully')->success();

		return redirect('book2s');
	}

	public function edit($id)
	{
		$book2 = $this->book2Service->find($id);

		return view('book2s.edit', compact('book2', 'id'));
	}

	public function update(Book2UpdateRequest $request, $id)
	{
		$book2 = $this->book2Service->findAndUpdate($request, $id);

		flash('{Module} updated successfully')->success();

		return redirect('book2s');
	}

	public function destroy($id)
	{
		$this->book2Service->destroy($id);

		flash('{Module} deleted successfully')->success();

		return redirect('book2s');
	}
}
