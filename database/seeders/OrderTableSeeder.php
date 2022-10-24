<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Retail;
use Illuminate\Database\Seeder;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use DB;

class OrderTableSeeder extends Seeder
{
    public function run()
    {
        // กำหนดส่งอีก 1 วัน
        $order = Retail::findOrFail('RETAIL-001');
        $id = IdGenerator::generate(['table' => 'orders', 'length' => 10, 'prefix' =>'ORDER-']);
        DB::table('orders')->insert([
            'id' => $id,
            'retail_id' => $order->id,
            'retail_name' => $order->retail_name,
            'retail_province' => $order->retail_province,
            'retail_district' => $order->retail_district,
            'retail_sub_district' => $order->retail_sub_district,
            'retail_postcode' => $order->retail_postcode,
            'order_transportDate' => \Carbon\Carbon::now()->add(1, 'day')->format('Y-m-d H:i:s'), 
            'created_at' => now()
        ]);

         // ไม่มีกำหนดส่ง
        $order = Retail::findOrFail('RETAIL-002');
        $id = IdGenerator::generate(['table' => 'orders', 'length' => 10, 'prefix' =>'ORDER-']);
        DB::table('orders')->insert([
            'id' => $id,
            'retail_id' => $order->id,
            'retail_name' => $order->retail_name,
            'retail_province' => $order->retail_province,
            'retail_district' => $order->retail_district,
            'retail_sub_district' => $order->retail_sub_district,
            'retail_postcode' => $order->retail_postcode,
            'created_at' => now()
        ]);

        // สั่งเมื่อวาน sub 1 day
        // ส่งแบบกำหนดวันที่
        $order = Retail::findOrFail('RETAIL-003');
        $id = IdGenerator::generate(['table' => 'orders', 'length' => 10, 'prefix' =>'ORDER-']);
        DB::table('orders')->insert([
            'id' => $id,
            'retail_id' => $order->id,
            'retail_name' => $order->retail_name,
            'retail_province' => $order->retail_province,
            'retail_district' => $order->retail_district,
            'retail_sub_district' => $order->retail_sub_district,
            'retail_postcode' => $order->retail_postcode,
            'order_date' => \Carbon\Carbon::now()->sub(1, 'day')->format('Y-m-d H:i:s'), 
            'order_transportDate' => \Carbon\Carbon::create('2022-10-28 12:00:00'), 
            'created_at' => now()
        ]);

        $order = Retail::findOrFail('RETAIL-004');
        $id = IdGenerator::generate(['table' => 'orders', 'length' => 10, 'prefix' =>'ORDER-']);
        DB::table('orders')->insert([
            'id' => $id,
            'retail_id' => $order->id,
            'retail_name' => $order->retail_name,
            'retail_province' => $order->retail_province,
            'retail_district' => $order->retail_district,
            'retail_sub_district' => $order->retail_sub_district,
            'retail_postcode' => $order->retail_postcode,
            'created_at' => now()
        ]);

        $order = Retail::findOrFail('RETAIL-005');
        $id = IdGenerator::generate(['table' => 'orders', 'length' => 10, 'prefix' =>'ORDER-']);
        DB::table('orders')->insert([
            'id' => $id,
            'retail_id' => $order->id,
            'retail_name' => $order->retail_name,
            'retail_province' => $order->retail_province,
            'retail_district' => $order->retail_district,
            'retail_sub_district' => $order->retail_sub_district,
            'retail_postcode' => $order->retail_postcode,
            'created_at' => now()
        ]);

        $order = Retail::findOrFail('RETAIL-006');
        $id = IdGenerator::generate(['table' => 'orders', 'length' => 10, 'prefix' =>'ORDER-']);
        DB::table('orders')->insert([
            'id' => $id,
            'retail_id' => $order->id,
            'retail_name' => $order->retail_name,
            'retail_province' => $order->retail_province,
            'retail_district' => $order->retail_district,
            'retail_sub_district' => $order->retail_sub_district,
            'retail_postcode' => $order->retail_postcode,
            'order_date' => \Carbon\Carbon::now()->sub(1, 'day')->format('Y-m-d H:i:s'), 
            'order_transportDate' => \Carbon\Carbon::create('2022-11-1 12:00:00'), 
            'created_at' => now()
        ]);

        $order = Retail::findOrFail('RETAIL-007');
        $id = IdGenerator::generate(['table' => 'orders', 'length' => 10, 'prefix' =>'ORDER-']);
        DB::table('orders')->insert([
            'id' => $id,
            'retail_id' => $order->id,
            'retail_name' => $order->retail_name,
            'retail_province' => $order->retail_province,
            'retail_district' => $order->retail_district,
            'retail_sub_district' => $order->retail_sub_district,
            'retail_postcode' => $order->retail_postcode,
            'created_at' => now()
        ]);

        $order = Retail::findOrFail('RETAIL-002');
        $id = IdGenerator::generate(['table' => 'orders', 'length' => 10, 'prefix' =>'ORDER-']);
        DB::table('orders')->insert([
            'id' => $id,
            'retail_id' => $order->id,
            'retail_name' => $order->retail_name,
            'retail_province' => $order->retail_province,
            'retail_district' => $order->retail_district,
            'retail_sub_district' => $order->retail_sub_district,
            'retail_postcode' => $order->retail_postcode,
            'order_date' => \Carbon\Carbon::create('2022-10-20 10:09:00'), 
            'order_transportDate' => \Carbon\Carbon::create('2022-10-22 09:27:40'), 
            'created_at' => now()
        ]);

        $order = Retail::findOrFail('RETAIL-007');
        $id = IdGenerator::generate(['table' => 'orders', 'length' => 10, 'prefix' =>'ORDER-']);
        DB::table('orders')->insert([
            'id' => $id,
            'retail_id' => $order->id,
            'retail_name' => $order->retail_name,
            'retail_province' => $order->retail_province,
            'retail_district' => $order->retail_district,
            'retail_sub_district' => $order->retail_sub_district,
            'retail_postcode' => $order->retail_postcode,
            'order_date' => \Carbon\Carbon::create('2022-10-20 10:11:00'), 
            'order_transportDate' => \Carbon\Carbon::create('2022-10-24 13:15:50'), 
            'created_at' => now()
        ]);

        $order = Retail::findOrFail('RETAIL-012');
        $id = IdGenerator::generate(['table' => 'orders', 'length' => 10, 'prefix' =>'ORDER-']);
        DB::table('orders')->insert([
            'id' => $id,
            'retail_id' => $order->id,
            'retail_name' => $order->retail_name,
            'retail_province' => $order->retail_province,
            'retail_district' => $order->retail_district,
            'retail_sub_district' => $order->retail_sub_district,
            'retail_postcode' => $order->retail_postcode,
            'created_at' => now()
        ]);
    }
}
