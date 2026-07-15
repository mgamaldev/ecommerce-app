<?php

namespace App\Interfaces;

use App\Models\Order;

interface PaymentGatewayInterface
{
    public function checkout(Order $order): array;
}
