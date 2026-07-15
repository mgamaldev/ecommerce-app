<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\VariantCreateRequest;
use App\Http\Requests\Admin\VariantUpdateRequest;
use App\Http\Resources\VariantResource;
use App\Models\Variant;
use App\Services\Admin\VariantService;
use Illuminate\Http\JsonResponse;

class AdminVariantController extends ApiController
{
    public function __construct(protected VariantService $variantService) {}

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Variant::class);

        $variants = $this->variantService->getAll();

        return $this->success(VariantResource::collection($variants), 'All variants');
    }

    public function show(Variant $variant): JsonResponse
    {
        $this->authorize('view', $variant);

        $variant = $this->variantService->getDetails($variant->id);

        return $this->success(new VariantResource($variant), 'Variant details');
    }

    public function update(VariantUpdateRequest $request, Variant $variant): JsonResponse
    {
        $this->authorize('update', $variant);

        $variant = $this->variantService->update($variant->id, $request->validated());

        return $this->success(new VariantResource($variant), 'variant updated successfully');
    }

    public function store(VariantCreateRequest $request): JsonResponse
    {
        $this->authorize('create', Variant::class);

        $addVariant = $this->variantService->create($request->validated());

        return $this->success(new VariantResource($addVariant), 'Variant added successfully');
    }

    public function destroy(Variant $variant): JsonResponse
    {
        $this->authorize('delete', $variant);

        $variant = $this->variantService->softDelete($variant->id);

        return $this->success(new VariantResource($variant), 'variant deleted successfully');
    }

    public function forceDelete(int $id): JsonResponse
    {
        $variant = Variant::withTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $variant);

        $this->variantService->forceDelete($id);

        return $this->success(new VariantResource($variant), 'Variant permanently deleted');
    }

    public function restore(int $id): JsonResponse
    {
        $variant = Variant::withTrashed()->findOrFail($id);

        $this->authorize('restore', $variant);

        $variant = $this->variantService->restore($id);

        return $this->success(new VariantResource($variant), 'Variant restored successfully');
    }
}
