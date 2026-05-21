<?php

namespace App\Services;

use App\Http\Requests\CartItemRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Variant;
use App\Services\Gateways\StripeService;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function __construct(public CartItemService $cartItemService, public StripeService $stripe) {}

    public function checkout(CartItemRequest $request)
    {
        $cartItem = $this->cartItemService->userCart($request);
        $user = auth()->user();

        return DB::transaction(function () use ($user, $cartItem) {

            $product = Product::with('variants')->lockForUpdate()->first();

            $variant = Variant::where('product_id', $product->id)->first();

            $totalPrice = $cartItem->quantity * $product->base_price;

            $order = Order::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'total_amount' => $totalPrice,
                'status' => 'pending',
            ]);

            return $this->stripe->checkout($order);
        });
    }
}
