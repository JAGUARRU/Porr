<?php

namespace Database\Seeders;
use Haruncpi\LaravelIdGenerator\IdGenerator;

use DB;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config = [
            'table' => 'products',
            'length' => 10,
            'prefix' => 'PROD-'
        ];
        
        $id = IdGenerator::generate($config);
        DB::table('products')->insert(['id' => $id, 'prod_name' => 'รสน้ำผึ้ง', 'prod_price' => 100, 'prod_type_name' => 'แท่ง', 'created_at' => now()]);
        $id = IdGenerator::generate($config);
        DB::table('products')->insert(['id' => $id, 'prod_name' => 'รสนม', 'prod_price' => 200, 'prod_type_name' => 'ถ้วย', 'created_at' => now()]);
    }
}