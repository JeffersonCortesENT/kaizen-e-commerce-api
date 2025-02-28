<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\ProductCategory;
use App\Models\product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'has_variants' => fake()->boolean(),
            'price' => fake()->randomFloat(2, 0, 99999999.99),
            'tax_type' => fake()->randomElement(["inclusive","exclusive"]),
            'brand_id' => Brand::factory(),
            'category_id' => ProductCategory::factory(),
        ];
    }
}
