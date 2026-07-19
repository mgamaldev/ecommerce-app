<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\VariantCreateRequest;
use App\Http\Requests\Admin\VariantUpdateRequest;
use App\Http\Resources\VariantResource;
use App\Models\Variant;
use App\Services\Admin\VariantService;
use Illuminate\Http\JsonResponse;

/**
 * @group Admin Variants
 *
 * Endpoints for managing variants. All endpoints in this group are available only to administrators.
 */
class AdminVariantController extends ApiController
{
    public function __construct(protected VariantService $variantService) {}

    /**
     * List of all variants.
     *
     * Retrieve all variants.
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Variant::class);

        $variants = $this->variantService->getAll();

        return $this->success(VariantResource::collection($variants), 'All variants');
    }

    /**
     * Show variant details.
     *
     * Retrieve the details of a specific variant.
     */
    public function show(Variant $variant): JsonResponse
    {
        $this->authorize('view', $variant);

        $variant = $this->variantService->getDetails($variant->id);

        return $this->success(new VariantResource($variant), 'Variant details');
    }

    /**
     * Update a variant.
     *
     * Update the information of an existing variant.
     */
    public function update(VariantUpdateRequest $request, Variant $variant): JsonResponse
    {
        $this->authorize('update', $variant);

        $variant = $this->variantService->update($variant->id, $request->validated());

        return $this->success(new VariantResource($variant), 'Variant updated successfully');
    }

    /**
     * Create a new variant.
     *
     * Create a new product variant.
     */
    public function store(VariantCreateRequest $request): JsonResponse
    {
        $this->authorize('create', Variant::class);

        $addVariant = $this->variantService->create($request->validated());

        return $this->success(new VariantResource($addVariant), 'Variant added successfully');
    }

    /**
     * Delete a variant.
     *
     * Soft delete a variant.
     */
    public function destroy(Variant $variant): JsonResponse
    {
        $this->authorize('delete', $variant);

        $variant = $this->variantService->softDelete($variant->id);

        return $this->success(new VariantResource($variant), 'Variant deleted successfully');
    }

    /**
     * Permanently delete a variant.
     *
     * Permanently remove a soft-deleted variant.
     */
    public function forceDelete(int $id): JsonResponse
    {
        $variant = Variant::withTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $variant);

        $this->variantService->forceDelete($id);

        return $this->success(new VariantResource($variant), 'Variant permanently deleted');
    }

    /**
     * Restore a variant.
     *
     * Restore a previously soft-deleted variant.
     */
    public function restore(int $id): JsonResponse
    {
        $variant = Variant::withTrashed()->findOrFail($id);

        $this->authorize('restore', $variant);

        $variant = $this->variantService->restore($id);

        return $this->success(new VariantResource($variant), 'Variant restored successfully');
    }
}
