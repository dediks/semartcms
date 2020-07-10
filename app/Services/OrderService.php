<?php

namespace Services;

use App\Order;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Auth;

class OrderService
{
	public function model()
	{
		return new Order;
	}
	public function getTableName()
	{
		return $this->model()->getTable();
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
			if ($relation_type == "many-many") {
				foreach ($data_relation as $datum_relation) {
					$datum_decoded = json_decode($datum_relation);

					if ($datum_decoded != null) {
						$created->{$target_model}()->attach($datum_decoded);
					}
				}
			} else if ($relation_type == "one-many" && $modifier == "hasMany") {
				$new_name_target_model = Str::singular($target_model);
				$new_name_target_model = Str::studly($new_name_target_model);

				foreach ($data_relation as $datum_relation) {
					$datum_decoded = json_decode($datum_relation);
					// dd($datum_decoded);

					$className = '\App\\' . $new_name_target_model;
					foreach ($datum_decoded as $a) {
						$result = $className::find($a);
						$created->{$target_model}()->save($result);
					}

					$created->refresh();
				}
			} else if ($modifier == "belongsTo" ||  $modifier == "hasOne") { //modifier belongsTo

				// dd($data_relation[0]);
				$new_name_target_model = Str::singular($target_model);
				$new_name_target_model_in_studly = Str::studly($new_name_target_model);


				$datum_decoded = json_decode($data_relation[0]);
				$id = $datum_decoded[0];

				$classTarget = 'App\\' . $new_name_target_model_in_studly;
				$data_target = $classTarget::find($id);

				$created->{$new_name_target_model}()->associate($data_target);
				$created->save();
			}
		} else { //jika tidak ada relasi
			dd("tidak ada relasi");
		}
		// dd($input);
	}

	public function create($request)
	{
		$input = $request->all();

		$cek_relation_exists = array_key_exists("temp_data_selected", $input);
		$this->checkIsAnyFileField($request, $input);

		if ($cek_relation_exists) {
			$new_input = Arr::except($input, ['temp_data_selected', 'data_target']);
			$create = $this->model()->create($new_input);
			$this->setRelation($input, $create);
		} else {
			$create = $this->model()->create($input);
		}

		return $create;
	}


	public function findAndUpdate($request, $id)
	{
		$order = $this->find($id);

		$input = $request->all();

		$cek_relation_exists = array_key_exists("temp_data_selected", $input);

		$input = $this->checkIsAnyFileField($request, $input);

		if ($cek_relation_exists) {
			$new_input = Arr::except($input, ['temp_data_selected', 'data_target']);
			// $create = $this->model()->create($new_input);
			$update = $category->update($new_input);
			$this->setRelation($input, $update);
		} else {
			$update = $category->update($input);
		}

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
