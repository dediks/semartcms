<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Services\SdasasService;
use Requests\{
	SdasasCreateRequest,
	SdasasUpdateRequest
};

class SdasasController extends Controller
{
	private $sdasasService;

	public function __construct(SdasasService $sdasas)
	{
		$this->sdasasService = $sdasas;
	}

	public function index()
	{
		$sdasas = $this->sdasasService->paginate(10);

		return view('sdasas.index', compact('sdasas'));
	}

	public function create()
	{
		return view('sdasas.create');
	}

	public function store(SdasasCreateRequest $request)
	{
		$create = $this->sdasasService->create($request);
		flash('{Module} created successfully')->success();

		return redirect('sdasas');
	}

	public function edit($id)
	{
		$sdasas = $this->sdasasService->find($id);

		return view('sdasas.edit', compact('sdasas', 'id'));
	}

	public function update(SdasasUpdateRequest $request, $id)
	{
		$sdasas = $this->sdasasService->findAndUpdate($request, $id);

		flash('{Module} updated successfully')->success();

		return redirect('sdasas');
	}

	public function destroy($id)
	{
		$this->sdasasService->destroy($id);

		flash('{Module} deleted successfully')->success();

		return redirect('sdasas');
	}
}
