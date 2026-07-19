<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends ApiController
{
    public function __construct(protected ProductService $productService) {}

    /**
     * List of all products.
     *
     * Retrieve all available products.
     */
    public function index(): JsonResponse
    {
        $products = $this->productService->getAllProducts();

        return $this->success(ProductResource::collection($products), 'All Products');
    }

    /**
     * Show product details.
     *
     * Retrieve the details of a specific product.
     */
    public function show(int $id): JsonResponse
    {
        $productDetails = $this->productService->getProductDetails($id);

        return $this->success(new ProductResource($productDetails), 'Product Details');
    }
}
