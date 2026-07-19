<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\VariantResource;
use App\Services\VariantService;
use Illuminate\Http\JsonResponse;

class VariantController extends ApiController
{
    public function __construct(protected VariantService $variantService) {}

    /**
     * List of all variants.
     *
     * Retrieve all available variants.
     */
    public function index(): JsonResponse
    {
        $variants = $this->variantService->getAllVariant();

        return $this->success(VariantResource::collection($variants), 'All Variants');
    }
}
