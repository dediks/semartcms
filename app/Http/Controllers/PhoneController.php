<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Services\PhoneService;
use Requests\{
	PhoneCreateRequest,
	PhoneUpdateRequest
};

class PhoneController extends Controller
{
	private $phoneService;

	public function __construct(PhoneService $phone)
	{
		$this->phoneService = $phone;
	}

	public function index()
	{
		$phones = $this->phoneService->paginate(10);

		return view('phones.index', compact('phones'));
	}

	public function create()
	{
		return view('phones.create');
	}

	public function store(PhoneCreateRequest $request)
	{
		$create = $this->phoneService->create($request);
		flash('{Module} created successfully')->success();

		return redirect('phones');
	}

	public function edit($id)
	{
		$phone = $this->phoneService->find($id);

		return view('phones.edit', compact('phone', 'id'));
	}

	public function update(PhoneUpdateRequest $request, $id)
	{
		$phone = $this->phoneService->findAndUpdate($request, $id);

		flash('{Module} updated successfully')->success();

		return redirect('phones');
	}

	public function destroy($id)
	{
		$this->phoneService->destroy($id);

		flash('{Module} deleted successfully')->success();

		return redirect('phones');
	}
}
