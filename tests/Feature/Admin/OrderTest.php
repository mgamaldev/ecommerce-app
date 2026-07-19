<?php

namespace Tests\Feature\Admin;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\Traits\AdminCrudAssertions;
use Tests\Support\Traits\ReadUpdateCrudTestSuite;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use AdminCrudAssertions;
    use ReadUpdateCrudTestSuite;
    use RefreshDatabase;

    protected function endpoint(): string
    {
        return '/api/admin/orders';
    }

    protected function modelFactory()
    {
        return Order::class;
    }

    protected function updateValidData(): array
    {
        return [
            'payment_status' => 'refund',
        ];
    }
}
