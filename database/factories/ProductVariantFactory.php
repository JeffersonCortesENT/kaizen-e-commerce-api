<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductVariantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductVariant::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'name' => fake()->name(),
            'sku' => fake()->word(),
            'barcode' => fake()->word(),
            'price' => fake()->randomFloat(2, 0, 99999999.99),
            'status' => fake()->randomElement(["active","inactive"]),
        ];
    }
}
