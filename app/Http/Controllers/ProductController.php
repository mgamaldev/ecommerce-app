<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected ProductService $productService) {}

    public function index(): JsonResponse
    {
        $products = $this->productService->getAllProducts();

        return $this->success(ProductResource::collection($products), 'All Products');
    }

    public function show(int $id): JsonResponse
    {
        $productDetails = $this->productService->getProductDetails($id);

        return $this->success(new ProductResource($productDetails), 'Product Details');
    }
}
