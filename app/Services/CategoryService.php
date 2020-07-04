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

		if (count($request->files) > 0) {
			foreach ($request->file() as $key => $image) {
				$input[$key] = $this->fileUpload($request, $key);
			}
		}

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

	public function fileUpload($request, $input_name)
	{
		// $this->validate($request, [
		// 	$input_name => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
		// ]);

		if ($request->hasFile($input_name)) {
			$image = $request->file($input_name);
			$name = time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/images');
			$image->move($destinationPath, $name);

			return "/images/" . $name;
		}
	}

	public function destroy($id)
	{
		return $this->find($id)->delete();
	}
}