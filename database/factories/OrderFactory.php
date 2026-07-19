<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),

            'total_amount' => $this->faker->numberBetween(50, 500),

            'payment_status' => $this->faker->randomElement([
                'pending',
                'paid',
                'refund',
            ]),

            'payment_method' => $this->faker->randomElement([
                'cash',
                'card',
                'stripe',
            ]),

            'transaction_id' => $this->faker->uuid(),

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
