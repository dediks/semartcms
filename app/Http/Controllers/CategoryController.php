<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Services\CategoryService;
use Requests\{
	CategoryCreateRequest,
	CategoryUpdateRequest
};

class CategoryController extends Controller
{
	private $categoryService;

	public function __construct(CategoryService $category)
	{
		$this->categoryService = $category;
	}

	public function index()
	{
		$categories = $this->categoryService->paginate(10);

		return view('categories.index', compact('categories'));
	}

	public function create()
	{
		return view('categories.create');
	}

	public function store(CategoryCreateRequest $request)
	{
		$create = $this->categoryService->create($request);
		flash('{Module} created successfully')->success();

		return redirect('categories');
	}

	public function edit($id)
	{
		$category = $this->categoryService->find($id);

		return view('categories.edit', compact('category', 'id'));
	}

	public function update(CategoryUpdateRequest $request, $id)
	{
		$category = $this->categoryService->findAndUpdate($request, $id);

		flash('{Module} updated successfully')->success();

		return redirect('categories');
	}

	public function destroy($id)
	{
		$this->categoryService->destroy($id);

		flash('{Module} deleted successfully')->success();

		return redirect('categories');
	}
}
