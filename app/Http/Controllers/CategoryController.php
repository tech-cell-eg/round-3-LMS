<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(Category::all(), 'Categories retrieved successfully');
    }

    public function show(Category $category)
    {
        return $this->successResponse($category, 'Category retrieved successfully');
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return $this->successResponse($category, 'Category created successfully');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return $this->successResponse($category, 'Category updated successfully');
    }

    public function destroy(CategoryRequest $request, Category $category)
    {
        $category->delete();
        return $this->successResponse(null, 'Category deleted successfully');
    }
}
