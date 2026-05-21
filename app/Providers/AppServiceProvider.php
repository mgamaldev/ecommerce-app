<?php

namespace App\Providers;

use App\Interfaces\PaymentGatewayInterface;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Variant;
use App\Observers\BaseObserver;
use App\Observers\OrderObserver;
use App\Observers\UserObserver;
use App\Services\Gateways\StripeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(PaymentGatewayInterface::class, StripeService::class);
    }

    public function boot(): void
    {
        Category::observe(BaseObserver::class);
        Product::observe(BaseObserver::class);
        Variant::observe(BaseObserver::class);
        User::observe(UserObserver::class);
        Order::observe(OrderObserver::class);
    }
}
