<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  public function run()
  {
      $this->call([
          AccountDefaultData::class,
          ProductSeeder::class,
          ProductVariantSeeder::class,
      ]);
  }
}
