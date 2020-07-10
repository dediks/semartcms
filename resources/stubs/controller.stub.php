<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Services\{Service};
use Illuminate\Support\Facades\Gate;
use Requests\{
	{Model}CreateRequest,
	{Model}UpdateRequest
};

class {Model}Controller extends Controller
{
	private ${serviceCamel};

	public function __construct({Service} ${var})
	{
		$this->{serviceCamel} = ${var};

		$this->middleware(function ($request, $next) {
			if (Gate::allows('show-this',  $this->{serviceCamel}->getTableName())) return $next($request);

			abort(403, 'Anda tidak memiliki cukup hak akses');
		});
	}

	public function index()
	{
		${var_plural} = $this->{serviceCamel}->paginate(10);

		return view('{view}.index', compact('{var_plural}'));
	}

	public function create()
	{
		return view('{view}.create');
	}

	public function store({Model}CreateRequest $request)
	{
		$create = $this->{serviceCamel}->create($request);
		flash('{Module} created successfully')->success();

		return redirect('{route}');
	}

	public function edit($id)
	{
		${var} = $this->{serviceCamel}->find($id);

		return view('{view}.edit', compact('{var}', 'id'));
	}

	public function update({Model}UpdateRequest $request, $id)
	{
		${var} = $this->{serviceCamel}->findAndUpdate($request, $id);

		flash('{Module} updated successfully')->success();

		return redirect('{route}');
	}

	public function destroy($id)
	{
		$this->{serviceCamel}->destroy($id);

		flash('{Module} deleted successfully')->success();

		return redirect('{route}');
	}
}
