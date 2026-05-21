<?php

namespace App\Http\Controllers;

use App\Exceptions\OutOfStockException;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\CartItemRequest;
use App\Services\CheckoutService;

class CheckOutController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected CheckoutService $checkoutService) {}

    public function store(CartItemRequest $request)
    {
        try {

            $session = $this->checkoutService->checkout($request);

            return $this->success('Checkout session created', ['checkout_url' => $session['url']]);

        } catch (OutOfStockException $e) {

            return $this->error('Out of stock');
        }
    }
}
