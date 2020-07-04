<?php

namespace Services;

use App\Book;
use Auth;
use Illuminate\Support\Arr;

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

	public function checkIsAnyFileField($request)
	{
		if (count($request->files) > 0) {
			foreach ($request->file() as $key => $image) {
				$input[$key] = $this->fileUpload($request, $key);
			}
		}
	}

	public function setRelation($input, $created)
	{
		$data_relation = $input["temp_data_selected"]; // list id
		$data_target = $input["data_target"]; //string (ex: categories, many-many, belongsToMany)
		$data_target_exploded = explode(',', $data_target); //0 : target_model, 1 : name, 2 : modifier
		$target_model = $data_target_exploded[0];

		// dd($target_model);
		$relation_type = $data_target_exploded[1];
		$modifier = $data_target_exploded[2];

		// dd($data_target_exploded);

		if ($data_relation) {
			foreach ($data_relation as $datum_relation) {
				$datum_decoded = json_decode($datum_relation);

				$created->{$target_model}()->attach($datum_decoded);

				// dd($datum_decoded);
			}
		} else {
			dd("tidak ada");
		}
		// dd($input);
	}


	public function create($request)
	{
		$input = $request->all();

		$data_relation = $input["temp_data_selected"]; // list id
		$this->checkIsAnyFileField($request);

		if ($data_relation) {
			$new_input = Arr::except($input, ['temp_data_selected', 'data_target']);
			$create = $this->model()->create($new_input);
		} else {
			$create = $this->model()->create($input);
		}

		$this->setRelation($input, $create);

		return $create;
	}

	public function findAndUpdate($request, $id)
	{
		$book = $this->find($id);

		$input = $request->all();

		$update = $book->update($input);

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
