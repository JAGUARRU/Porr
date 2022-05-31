<?php

namespace Database\Seeders;
use Haruncpi\LaravelIdGenerator\IdGenerator;

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
        $config = [
            'table' => 'product_categories',
            'length' => 6,
            'prefix' => 'C'
        ];
        
        $id = IdGenerator::generate($config);
        DB::table('product_categories')->insert(['id' => $id, 'name' => 'แท่ง']);
        $id = IdGenerator::generate($config);
        DB::table('product_categories')->insert(['id' => $id, 'name' => 'ถ้วย']);
    }
}