<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
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
            'name' => fake()->word(), 
            'sku' => fake()->unique()->bothify('??###'), // Example: "AB123"
            'barcode' => fake()->unique()->ean13(), // Generates a 13-digit barcode
            'price' => fake()->randomFloat(2, 1, 99999), // Ensure price is valid
            'status' => fake()->randomElement(["active", "inactive"]),
        ];
    }
}
