<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use DB;

class TrucksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
  
        $id = IdGenerator::generate(['table' => 'trucks', 'length' => 6, 'prefix' =>'T-']);

        DB::table('trucks')->insert([
            'id' => $id,
            'plateNumber' => 'พค 8183',
            'status' => 'พร้อมใช้งาน',
            'truck_province' => 'พิษณุโลก',
            'truck_district' => 'วังทอง',
            'truck_sub_district' => 'ดินทอง',
            'truck_postcode' => '65130',
            'user_id' => 5,
            'created_at' => now()
        ]);

        $id = IdGenerator::generate(['table' => 'trucks', 'length' => 6, 'prefix' =>'T-']);
        
        DB::table('trucks')->insert([
            'id' => $id,
            'plateNumber' => 'พค 8381',
            'status' => 'พร้อมใช้งาน',
            'truck_province' => 'พิษณุโลก',
            'truck_district' => 'วังทอง',
            'truck_sub_district' => 'ดินทอง',
            'truck_postcode' => '65130',
            'user_id' => 4,
            'created_at' => now()
        ]);
      
        $id = IdGenerator::generate(['table' => 'trucks', 'length' => 6, 'prefix' =>'T-']);
        
        DB::table('trucks')->insert([
            'id' => $id,
            'plateNumber' => 'พค 8318',
            'status' => 'พร้อมใช้งาน',
            'truck_province' => 'พิษณุโลก',
            'truck_district' => 'วังทอง',
            'truck_sub_district' => 'ดินทอง',
            'truck_postcode' => '65130',
            'user_id' => 3,
            'created_at' => now()
        ]);
    
        $id = IdGenerator::generate(['table' => 'trucks', 'length' => 6, 'prefix' =>'T-']);
        
        DB::table('trucks')->insert([
            'id' => $id,
            'plateNumber' => 'พค 8813',
            'status' => 'พร้อมใช้งาน',
            'truck_province' => 'พิษณุโลก',
            'truck_district' => 'นครไทย',
            'truck_sub_district' => 'นาบัว',
            'truck_postcode' => '65120',
            'user_id' => 1,
            'created_at' => now()
        ]);
    }
    
}
