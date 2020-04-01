<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Services\CustomerService;
use Requests\{
	CustomerCreateRequest,
	CustomerUpdateRequest
};

class CustomerController extends Controller
{
	private $customerService;

	public function __construct(CustomerService $customer)
	{
		$this->customerService = $customer;
	}

	public function index()
	{
		$customers = $this->customerService->paginate(10);

		return view('customers.index', compact('customers'));
	}

	public function create()
	{
		return view('customers.create');
	}

	public function store(CustomerCreateRequest $request)
	{
		$create = $this->customerService->create($request);
		flash('{Module} created successfully')->success();

		return redirect('customers');
	}

	public function edit($id)
	{
		$customer = $this->customerService->find($id);

		return view('customers.edit', compact('customer', 'id'));
	}

	public function update(CustomerUpdateRequest $request, $id)
	{
		$customer = $this->customerService->findAndUpdate($request, $id);

		flash('{Module} updated successfully')->success();

		return redirect('customers');
	}

	public function destroy($id)
	{
		$this->customerService->destroy($id);

		flash('{Module} deleted successfully')->success();

		return redirect('customers');
	}
}
