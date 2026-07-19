<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends ApiController
{
    public function __construct(protected CategoryService $categoryService) {}

    /**
     * List of all categories.
     *
     * Retrieve all available categories.
     */
    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAllCategories();

        return $this->success(CategoryResource::collection($categories), 'All Categories');
    }

    /**
     * Show category details.
     *
     * Retrieve the details of a specific category.
     */
    public function show(int $id): JsonResponse
    {
        $categoryDetails = $this->categoryService->getCategoryDetails($id);

        return $this->success(new CategoryResource($categoryDetails), 'Category Details');
    }
}
