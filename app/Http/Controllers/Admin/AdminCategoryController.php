<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\CategoryCreateRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\Admin\CategoryService;
use Illuminate\Http\JsonResponse;

/**
 * @group Admin Categories
 *
 * Endpoints for managing categories. All endpoints in this group are available only to administrators.
 */
class AdminCategoryController extends ApiController
{
    public function __construct(protected CategoryService $categoryService) {}

    /**
     * List of all categories.
     *
     * Retrieve all categories.
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Category::class);

        $categories = $this->categoryService->getAll();

        return $this->success(CategoryResource::collection($categories), 'All categories');
    }

    /**
     * Show category details.
     *
     * Retrieve the details of a specific category.
     */
    public function show(Category $category): JsonResponse
    {
        $this->authorize('view', $category);

        $category = $this->categoryService->getDetails($category->id);

        return $this->success(new CategoryResource($category), 'Category details');
    }

    /**
     * Update a category.
     *
     * Update an existing category.
     */
    public function update(CategoryUpdateRequest $request, Category $category): JsonResponse
    {
        $this->authorize('update', $category);

        $category = $this->categoryService->update($category->id, $request->validated());

        return $this->success(new CategoryResource($category), 'Category updated successfully');
    }

    /**
     * Create a new category.
     *
     * Create a new product category.
     */
    public function store(CategoryCreateRequest $request, Category $category): JsonResponse
    {
        $this->authorize('create', Category::class);

        $addCategory = $this->categoryService->create($request->validated());

        return $this->success(new CategoryResource($addCategory), 'Category added successfully');
    }

    /**
     * Delete a category.
     *
     * Soft delete a category.
     */
    public function destroy(Category $category): JsonResponse
    {
        $this->authorize('delete', $category);

        $category = $this->categoryService->softDelete($category->id);

        return $this->success(new CategoryResource($category), 'Category deleted successfully');
    }

    /**
     * Permanently delete a category.
     *
     * Permanently remove a soft-deleted category.
     */
    public function forceDelete(int $id): JsonResponse
    {
        $category = Category::withTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $category);

        $this->categoryService->forceDelete($id);

        return $this->success('Category permanently deleted');
    }

    /**
     * Restore a category.
     *
     * Restore a previously soft-deleted category.
     */
    public function restore(int $id): JsonResponse
    {
        $category = Category::withTrashed()->findOrFail($id);

        $this->authorize('restore', $category);

        $category = $this->categoryService->restore($id);

        return $this->success(new CategoryResource($category), 'Category restored successfully');
    }
}
