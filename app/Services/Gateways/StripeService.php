<?php

namespace App\Services\Gateways;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\Order;

class StripeService implements PaymentGatewayInterface
{
    public function checkout(Order $order): array
    {
        $session = $order->user->checkout([
            'payment_method_types' => ['card'],

            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'egp',
                        'product_data' => [
                            'name' => $order->product_name,
                        ],
                        'unit_amount' => $order->total_amount * 100,
                    ],
                    'quantity' => $order->quantity,
                ],
            ],

            'mode' => 'payment',

            'success_url' => route('checkout.success', ['order' => $order->id]),
            'cancel_url' => route('checkout.cancel', ['order' => $order->id]),

            'metadata' => [
                'order_id' => $order->id,
            ],

            'client_reference_id' => $order->id,
        ]);

         $order->update([
            'stripe_session_id' => $session->id,
        ]);

        return [
            'url' => $session->url,
            'session_id' => $session->id,
        ];
    }
}
