<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ProductInventory;
use App\Models\ProductVariant;

class ProductInventoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductInventory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_variant_id' => ProductVariant::factory(),
            'stock_quantity' => fake()->numberBetween(-10000, 10000),
            'reserved_stock' => fake()->numberBetween(-10000, 10000),
            'low_stock_threshold' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
