<?php

namespace Services;

use App\Book;
use Auth;

class BookService
{
	public function model()
	{
		return new Book;
	}

	public function all()
	{
		return $this->model()->all();
	}

	public function paginate($num)
	{
		return $this->model()->paginate($num);
	}

	public function find($id)
	{
		return $this->model()->find($id);
	}

	public function create($request)
	{
		$input = $request->all();

		$create = $this->model()->create($input);

		return $create;
	}

	public function findAndUpdate($request, $id)
	{
		$book = $this->find($id);

		$input = $request->all();

		$update = $book->update($input);

		return $update;
	}

	public function destroy($id)
	{
		return $this->find($id)->delete();
	}
}