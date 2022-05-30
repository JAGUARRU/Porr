<?php

namespace Database\Seeders;

use Database\Seeders\UserSeeder;
use Database\Seeders\ProductCategorySeeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(ProductCategorySeeder::class);
    }
}
