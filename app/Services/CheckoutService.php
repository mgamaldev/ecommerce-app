<?php

namespace App\Services;

use App\Exceptions\OutOfStockException;
use App\Http\Requests\CartItemRequest;
use App\Interfaces\PaymentGatewayInterface;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function __construct(public CartItemService $cartItemService, public PaymentGatewayInterface $paymentGateway) {}

    public function checkout(CartItemRequest $request): array
    {
        $cartItem = $this->cartItemService->userCart($request);
        $user = auth()->user();

        return DB::transaction(function () use ($user, $cartItem) {

            $product = Product::with('variants')->lockForUpdate()->first();

            $totalPrice = $cartItem->quantity * $product->base_price;

            if ($product->stock < $cartItem->quantity) {
                throw new OutOfStockException;
            }

            $order = Order::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'total_amount' => $totalPrice,
                'status' => 'pending',
            ]);

            return $this->paymentGateway->checkout($order);
        });
    }
}
