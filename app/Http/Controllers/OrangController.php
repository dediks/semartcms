<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Services\OrangService;
use Illuminate\Support\Facades\Gate;
use Requests\{
	OrangCreateRequest,
	OrangUpdateRequest
};

class OrangController extends Controller
{
	private $orangService;

	public function __construct(OrangService $orang)
	{
		$this->orangService = $orang;

		$this->middleware(function ($request, $next) {
			if (Gate::allows('show-this',  $this->orangService->getTableName())) return $next($request);

			abort(403, 'Anda tidak memiliki cukup hak akses');
		});
	}

	public function index()
	{
		$orangs = $this->orangService->paginate(10);

		return view('orangs.index', compact('orangs'));
	}

	public function create()
	{
		return view('orangs.create');
	}

	public function store(OrangCreateRequest $request)
	{
		$create = $this->orangService->create($request);
		flash('{Module} created successfully')->success();

		return redirect('orangs');
	}

	public function edit($id)
	{
		$orang = $this->orangService->find($id);

		return view('orangs.edit', compact('orang', 'id'));
	}

	public function update(OrangUpdateRequest $request, $id)
	{
		$orang = $this->orangService->findAndUpdate($request, $id);

		flash('{Module} updated successfully')->success();

		return redirect('orangs');
	}

	public function destroy($id)
	{
		$this->orangService->destroy($id);

		flash('{Module} deleted successfully')->success();

		return redirect('orangs');
	}
}
