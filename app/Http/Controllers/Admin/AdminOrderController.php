<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\Admin\OrderService;
use Illuminate\Http\JsonResponse;

/**
 * @group Admin Orders
 *
 * Endpoints for managing orders. All endpoints in this group are available only to administrators.
 */
class AdminOrderController extends ApiController
{
    public function __construct(protected OrderService $orderService) {}

    /**
     * List of all orders.
     *
     * Retrieve all orders.
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Order::class);

        $orders = $this->orderService->getAllOrders();

        return $this->success(OrderResource::collection($orders), 'All orders');
    }

    /**
     * Show order details.
     *
     * Retrieve the details of a specific order.
     */
    public function show(Order $order): JsonResponse
    {
        $this->authorize('view', $order);

        $order = $this->orderService->getOrder($order->id);

        return $this->success(new OrderResource($order), 'Order details');
    }

    /**
     * Update an order.
     *
     * Update the status or information of an existing order.
     */
    public function update(OrderUpdateRequest $request, Order $order): JsonResponse
    {
        $this->authorize('update', $order);

        $order = $this->orderService->updateOrder($order->id, $request->validated());

        return $this->success(new OrderResource($order), 'Order updated successfully');
    }
}
