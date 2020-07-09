<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Services\TestService;
use Requests\{
	TestCreateRequest,
	TestUpdateRequest
};

class TestController extends Controller
{
	private $testService;

	public function __construct(TestService $test)
	{
		$this->testService = $test;
	}

	public function index()
	{
		$tests = $this->testService->paginate(10);

		return view('tests.index', compact('tests'));
	}

	public function create()
	{
		return view('tests.create');
	}

	public function store(TestCreateRequest $request)
	{
		$create = $this->testService->create($request);
		flash('{Module} created successfully')->success();

		return redirect('tests');
	}

	public function edit($id)
	{
		$test = $this->testService->find($id);

		return view('tests.edit', compact('test', 'id'));
	}

	public function update(TestUpdateRequest $request, $id)
	{
		$test = $this->testService->findAndUpdate($request, $id);

		flash('{Module} updated successfully')->success();

		return redirect('tests');
	}

	public function destroy($id)
	{
		$this->testService->destroy($id);

		flash('{Module} deleted successfully')->success();

		return redirect('tests');
	}
}
