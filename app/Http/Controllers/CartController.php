<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\CartItemResource;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;

class CartController extends ApiController
{
    public function __construct(protected CartService $cartService) {}

    public function index(): JsonResponse
    {
        $cartItem = $this->cartService->userCart();

        return $this->success(new CartItemResource($cartItem), 'Cart Items');
    }
}
