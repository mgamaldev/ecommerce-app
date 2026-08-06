<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\CartItemRequest;
use App\Services\CheckoutService;
use Illuminate\Http\JsonResponse;

class CheckOutController extends ApiController
{
    public function __construct(protected CheckoutService $checkoutService) {}

    /**
     * Create a checkout session.
     *
     * Create a new checkout session for the authenticated user's cart.
     */
    public function store(CartItemRequest $request): JsonResponse
    {
        $session = $this->checkoutService->checkout($request);

        return $this->success(['checkout_url' => $session['url']], 'Checkout session created');
    }
}
