<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected CategoryService $categoryService) {}

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAllCategories();

        return $this->success(CategoryResource::collection($categories), 'All Categories');
    }

    public function show(int $id): JsonResponse
    {
        $categoryDetails = $this->categoryService->getCategoryDetails($id);

        return $this->success(new CategoryResource($categoryDetails), 'Category Details');
    }
}
