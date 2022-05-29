<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_categories')->insert(['id' => 'c1000', 'name' => 'แท่ง']);
        DB::table('product_categories')->insert(['id' => 'c1001', 'name' => 'ถ้วย']);
    }
}
