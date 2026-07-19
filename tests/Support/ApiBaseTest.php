<?php

namespace Tests\Support;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class ApiBaseTest extends TestCase
{
    use RefreshDatabase;

    public function assertApiSuccess($response, $status = 200)
    {
        $response->assertStatus($status);
        $response->assertJson([
            'status' => true,
        ]);
        $response->assertJsonStructure([
            'status',
            'message',
            'data',
        ]);
    }

    public function assertApiError($response, $status = 400)
    {
        $response->assertStatus($status);
        $response->assertJson(['status' => false]);
        $response->assertJsonStructure([
            'status',
            'message',
        ]);
    }

    public function assertValidationError($response, $field)
    {
        $response->assertStatus(422);
        $response->assertJsonValidationErrors($field);
    }
}
