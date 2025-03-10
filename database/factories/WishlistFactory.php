<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Account;
use App\Models\Product;
use App\Models\Wishlist;

class WishlistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Wishlist::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
