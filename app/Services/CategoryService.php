<?php

namespace Services;

use App\Category;
use Auth;

class CategoryService
{
	public function model()
	{
		return new Category;
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
		$category = $this->find($id);

		$input = $request->all();

		$update = $category->update($input);

		return $update;
	}

	public function destroy($id)
	{
		return $this->find($id)->delete();
	}
}