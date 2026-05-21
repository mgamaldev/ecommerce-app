<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Listeners\HandleStripeWebhook;
use App\Listeners\SendOrderEmailListener;
use App\Listeners\SendWelcomeEmailListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Cashier\Events\WebhookReceived;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderPlaced::class => [SendOrderEmailListener::class],
        Registered::class => [SendWelcomeEmailListener::class],
        WebhookReceived::class => [HandleStripeWebhook::class],

    ];
}
