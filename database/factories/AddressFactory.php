<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\address;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'address_line_1' => fake()->word(),
            'address_line_2' => fake()->word(),
            'city' => fake()->city(),
            'state' => fake()->word(),
            'postal_code' => fake()->postcode(),
            'country' => fake()->country(),
        ];
    }
}
