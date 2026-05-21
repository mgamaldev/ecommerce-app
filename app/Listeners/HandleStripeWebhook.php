<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Events\WebhookReceived;

class HandleStripeWebhook
{
    public function handle(WebhookReceived $event): void
    {
        $payload = $event->payload;

        if ($payload['type'] !== 'checkout.session.completed') {
            return;
        }

        $session = $payload['data']['object'];

        DB::transaction(function () use ($session) {

            $order = Order::where('stripe_session_id', $session['id'])->first();

            if (! $order || $order->status === 'paid') {
                return;
            }

            $product = $order->product;

            $variant = $product->variants()->first();

            $product->decrement('stock', $order->quantity);

            $variant?->decrement('variant_stock', $order->quantity);

            $order->update(['status' => 'paid']);

            event(new OrderPlaced($order));
        });
    }
}
