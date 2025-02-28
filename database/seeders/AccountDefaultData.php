<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class AccountDefaultData extends Seeder
{
    public function run()
    {
       // Create a default admin account
       Account::updateOrCreate(
          ['email' => 'admin@example.com'], // Prevent duplicate entry
          [
              'name' => 'Admin User',
              'password' => Hash::make('password123'), // Always hash passwords
              'role' => 'admin' // If you have a role column
          ]
      );

      // Create a default customer account
      Account::updateOrCreate(
          ['email' => 'customer@example.com'],
          [
              'name' => 'Customer User',
              'password' => Hash::make('password123'),
              'role' => 'customer'
          ]
      );
    }
}
