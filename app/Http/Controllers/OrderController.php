<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Services\OrderService;
use Requests\{
	OrderCreateRequest,
	OrderUpdateRequest
};

class OrderController extends Controller
{
	private $orderService;

	public function __construct(OrderService $order)
	{
		$this->orderService = $order;
	}

	public function index()
	{
		$orders = $this->orderService->paginate(10);

		return view('orders.index', compact('orders'));
	}

	public function create()
	{
		return view('orders.create');
	}

	public function store(OrderCreateRequest $request)
	{
		$create = $this->orderService->create($request);
		flash('{Module} created successfully')->success();

		return redirect('orders');
	}

	public function edit($id)
	{
		$order = $this->orderService->find($id);

		return view('orders.edit', compact('order', 'id'));
	}

	public function update(OrderUpdateRequest $request, $id)
	{
		$order = $this->orderService->findAndUpdate($request, $id);

		flash('{Module} updated successfully')->success();

		return redirect('orders');
	}

	public function destroy($id)
	{
		$this->orderService->destroy($id);

		flash('{Module} deleted successfully')->success();

		return redirect('orders');
	}
}
