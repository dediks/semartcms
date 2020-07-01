<?php

namespace Services;

use App\Phone;
use Auth;

class PhoneService
{
	public function model()
	{
		return new Phone;
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
		$phone = $this->find($id);

		$input = $request->all();

		$update = $phone->update($input);

		return $update;
	}

	public function destroy($id)
	{
		return $this->find($id)->delete();
	}
}