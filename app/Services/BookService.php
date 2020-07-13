<?php

namespace Services;

use App\Book;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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

	public function getTableName()
	{
		return $this->model()->getTable();
	}

	public function paginate($num)
	{
		return $this->model()->paginate($num);
	}

	public function find($id)
	{
		return $this->model()->find($id);
	}

	public function checkIsAnyFileField($request, $input)
	{
		if (count($request->files) > 0) {
			foreach ($request->file() as $key => $image) {
				$input[$key] = $this->fileUpload($request, $key);
			}

			return $input;
		}
		return $input;
	}

	public function setRelation($input, $created, $op)
	{
		$data_relation = $input["temp_data_selected"]; // list id
		$data_target = $input["data_target"]; //string (ex: categories, many-many, belongsToMany)

		foreach ($data_target as $key => $datum_target) {
			$data_target_exploded = explode(',', $datum_target); //0 : target_model, 1 : name, 2 : modifier

			$target_model = $data_target_exploded[0];
			$relation_type = $data_target_exploded[1];
			$modifier = $data_target_exploded[2];

			$new_name_target_model = Str::singular($target_model);
			$new_name_target_model = Str::studly($new_name_target_model);

			$relation_data_decoded = json_decode($data_relation[$key]);
			$className = 'App\\' . $new_name_target_model;
			$model_dir = base_path($className) . '.php';

			if (file_exists($model_dir) && $relation_data_decoded)
				if ($relation_type == "many-many") {
					if ($op == "create")
						$created->{$target_model}()->attach($relation_data_decoded);
					else
						$created->{$target_model}()->sync($relation_data_decoded);
				} else if ($relation_type == "one-many" && $modifier == "hasMany") {
					$result = $className::find($relation_data_decoded);
					$created->{$target_model}()->save($result);
					$created->refresh();
				}
				else if ($modifier == "belongsTo" ||  $modifier == "hasOne") {
					$target_model = Str::singular($target_model);
					$data_targeted = $className::find($relation_data_decoded);
					$created->{$target_model}()->associate($data_targeted);
					$created->save();
				}
		}
	}

	public function create($request)
	{
		$input = $request->all();
		$cek_relation_exists = array_key_exists("temp_data_selected", $input);
		$this->checkIsAnyFileField($request, $input);

		if ($cek_relation_exists) {
			$new_input = Arr::except($input, ['temp_data_selected', 'data_target']);
			$create = $this->model()->create($new_input);
			$this->setRelation($input, $create, "create");
		} else {
			$create = $this->model()->create($input);
		}

		return $create;
	}


	public function findAndUpdate($request, $id)
	{
		$book = $this->find($id);

		$input = $request->all();

		$cek_relation_exists = array_key_exists("temp_data_selected", $input);

		$input = $this->checkIsAnyFileField($request, $input);

		if ($cek_relation_exists) {
			$new_input = Arr::except($input, ['temp_data_selected', 'data_target']);
			$updated = $book->update($new_input);
			$this->setRelation($input, $book, "update");
		} else {
			$updated = $book->update($book);
		}

		return $updated;
	}

	public function fileUpload($request, $input_name)
	{
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
