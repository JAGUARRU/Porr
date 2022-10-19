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
        DB::table('products')->insert(['id' => $id, 'prod_name' => 'รสกะทิ', 'prod_price' => 5, 'prod_type_name' => 'แท่ง', 'created_at' => now()]);
        $id = IdGenerator::generate($config);
        DB::table('products')->insert(['id' => $id, 'prod_name' => 'รสชาไทย', 'prod_price' => 5, 'prod_type_name' => 'แท่ง', 'created_at' => now()]);
        $id = IdGenerator::generate($config);
        DB::table('products')->insert(['id' => $id, 'prod_name' => 'รสชาเขียว', 'prod_price' => 5, 'prod_type_name' => 'แท่ง', 'created_at' => now()]);
        $id = IdGenerator::generate($config);
        DB::table('products')->insert(['id' => $id, 'prod_name' => 'รสช็อกโกแลต', 'prod_price' => 5, 'prod_type_name' => 'แท่ง', 'created_at' => now()]);
        $id = IdGenerator::generate($config);
        DB::table('products')->insert(['id' => $id, 'prod_name' => 'รสสตรอว์เบอร์รี', 'prod_price' => 5, 'prod_type_name' => 'แท่ง', 'created_at' => now()]);
        $id = IdGenerator::generate($config);
        DB::table('products')->insert(['id' => $id, 'prod_name' => 'รสกะทิ', 'prod_price' => 10, 'prod_type_name' => 'ถ้วย', 'created_at' => now()]);
        $id = IdGenerator::generate($config);
        DB::table('products')->insert(['id' => $id, 'prod_name' => 'รสชาไทย', 'prod_price' => 10, 'prod_type_name' => 'ถ้วย', 'created_at' => now()]);
        $id = IdGenerator::generate($config);
        DB::table('products')->insert(['id' => $id, 'prod_name' => 'รสชาเขียว', 'prod_price' => 10, 'prod_type_name' => 'ถ้วย', 'created_at' => now()]);
        $id = IdGenerator::generate($config);
        DB::table('products')->insert(['id' => $id, 'prod_name' => 'รสช็อกโกแลต', 'prod_price' => 10, 'prod_type_name' => 'ถ้วย', 'created_at' => now()]);
        $id = IdGenerator::generate($config);
        DB::table('products')->insert(['id' => $id, 'prod_name' => 'รสสตรอว์เบอร์รี', 'prod_price' => 10, 'prod_type_name' => 'ถ้วย', 'created_at' => now()]);
    }
}