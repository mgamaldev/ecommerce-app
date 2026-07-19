<?php

namespace Tests\Support\Traits;

use App\Models\User;

trait AdminCrudAssertions
{
    protected function assertAdminSuccess(
        string $method, string $url, array $data = [], ?callable $successAssertions = null
    ): void {

        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin, 'sanctum')->json($method, $url, $data);

        if ($successAssertions) {
            $successAssertions($response);
        }

        $response->assertSuccessful();
    }

    protected function assertCustomerForbidden(
        string $method, string $url, array $data = []
    ): void {

        $customer = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($customer, 'sanctum')->json($method, $url, $data);

        $response->assertForbidden();
    }

    protected function assertGuestUnauthorized(
        string $method, string $url, array $data = []
    ): void {

        $response = $this->json($method, $url, $data);

        $response->assertUnauthorized();
    }
}
