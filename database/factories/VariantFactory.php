<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel:variant>
 */
class VariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'product_id' => Product::inRandomOrder()->first()?->id ?? 1,

            'sku' => $this->faker->unique()->bothify('SKU-####'),

            'price' => $this->faker->randomFloat(2, 50, 500),

            'variant_stock' => $this->faker->numberBetween(0, 100),

            'color' => $this->faker->safeColorName(),

            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),

            'created_at' => now(),

            'updated_at' => now(),

        ];
    }
}
