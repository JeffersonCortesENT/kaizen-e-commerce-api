<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\Order;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'total_amount' => fake()->randomFloat(2, 0, 99999999.99),
            'status' => fake()->randomElement(["pending","shipped","delivered","cancelled"]),
        ];
    }
}
