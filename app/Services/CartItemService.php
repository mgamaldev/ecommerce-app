<?php

namespace App\Services;

use App\Exceptions\OutOfStockException;
use App\Http\Requests\CartItemRequest;
use App\Models\CartItem;

class CartItemService
{
    public function __construct(public CartService $cartService) {}

    public function userCart(CartItemRequest $request): CartItem
    {
        $userCart = $this->cartService->userCart();

        $cartItem = CartItem::create([
            'cart_id' => $userCart->id,
            'variant_id' => $request->variant_id,
            'quantity' => $request->quantity,
        ]);

        $cartItem->load('variant.product');

        if ($cartItem->quantity > $cartItem->variant->variant_stock) {
            throw new OutOfStockException;
        }

        return $cartItem;
    }
}
