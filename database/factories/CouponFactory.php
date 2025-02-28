<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Discount;
use App\Models\coupon;

class CouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'code' => fake()->word(),
            'discount_id' => Discount::factory(),
            'usage_limit' => fake()->numberBetween(-10000, 10000),
            'expires_at' => fake()->dateTime(),
        ];
    }
}
