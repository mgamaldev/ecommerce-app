<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\ProductCreateRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Admin\ProductService;
use Illuminate\Http\JsonResponse;

/**
 * @group Admin Products
 *
 * Endpoints for managing products. All endpoints in this group are available only to administrators.
 */
class AdminProductController extends ApiController
{
    public function __construct(protected ProductService $productService) {}

    /**
     * List of all products.
     *
     * Retrieve all products.
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Product::class);

        $products = $this->productService->getAll();

        return $this->success(ProductResource::collection($products), 'All products');
    }

    /**
     * Show product details.
     *
     * Retrieve the details of a specific product.
     */
    public function show(Product $product): JsonResponse
    {
        $this->authorize('view', $product);

        $product = $this->productService->getDetails($product->id);

        return $this->success(new ProductResource($product), 'Product details');
    }

    /**
     * Update a product.
     *
     * Update the information of an existing product.
     */
    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        $this->authorize('update', $product);

        $product = $this->productService->update($product->id, $request->validated());

        return $this->success(new ProductResource($product), 'Product updated successfully');
    }

    /**
     * Create a new product.
     *
     * Create a new product with its information.
     */
    public function store(ProductCreateRequest $request): JsonResponse
    {
        $this->authorize('create', Product::class);

        $product = $this->productService->create($request->validated());

        return $this->success(new ProductResource($product), 'Product added successfully');
    }

    /**
     * Delete a product.
     *
     * Soft delete a product.
     */
    public function destroy(Product $product): JsonResponse
    {
        $this->authorize('delete', $product);

        $product = $this->productService->softDelete($product->id);

        return $this->success(new ProductResource($product), 'Product deleted successfully');
    }

    /**
     * Permanently delete a product.
     *
     * Permanently remove a soft-deleted product.
     */
    public function forceDelete(int $id): JsonResponse
    {
        $product = Product::withTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $product);

        $this->productService->forceDelete($id);

        return $this->success(new ProductResource($product), 'Product permanently deleted');
    }

    /**
     * Restore a product.
     *
     * Restore a previously soft-deleted product.
     */
    public function restore(int $id): JsonResponse
    {
        $product = Product::withTrashed()->findOrFail($id);

        $this->authorize('restore', $product);

        $product = $this->productService->restore($id);

        return $this->success(new ProductResource($product), 'Product restored successfully');
    }
}
