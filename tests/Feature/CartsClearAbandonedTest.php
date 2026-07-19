<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\ApiBaseTest;

class CartsClearAbandonedTest extends ApiBaseTest
{
    use RefreshDatabase;

    public function test_carts_clear_abandoned(): void
    {
        $this->artisan('carts:clear-abandoned')->assertSuccessful()->expectsOutput('Carts cleared');
    }
}
