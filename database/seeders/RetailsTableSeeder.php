<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use DB;

class RetailsTableSeeder extends Seeder
{

    public function run()
    {
  
        $id = IdGenerator::generate(['table' => 'retails', 'length' => 10, 'prefix' =>'RETAIL-']);

        DB::table('retails')->insert([
            'id' => $id,
            'retail_name' => 'ร้านฟุบุกามะ',
            'retail_address' => 'ธุรกิจท้องถิ่น 100 หมู่ที่ 3 บ้านโนน',
            'retail_province' => 'พิษณุโลก',
            'retail_district' => 'นครไทย',
            'retail_sub_district' => 'นาบัว',
            'retail_postcode' => '65120',
            'retail_phone' => '0979777777',
            'retail_contact' => '-',
            'created_at' => now()
        ]);

        $id = IdGenerator::generate(['table' => 'retails', 'length' => 10, 'prefix' =>'RETAIL-']);
        
        DB::table('retails')->insert([
            'id' => $id,
            'retail_name' => 'ร้านสารพัดกินเล่น',
            'retail_address' => 'ธุรกิจท้องถิ่น 101 หมู่ที่ 3 บ้านโนน',
            'retail_province' => 'พิษณุโลก',
            'retail_district' => 'นครไทย',
            'retail_sub_district' => 'นาบัว',
            'retail_postcode' => '65120',
            'retail_phone' => '0646653222',
            'retail_contact' => '-',
            'created_at' => now()
        ]);
      
        $id = IdGenerator::generate(['table' => 'retails', 'length' => 10, 'prefix' =>'RETAIL-']);
        
        DB::table('retails')->insert([
            'id' => $id,
            'retail_name' => 'ร้านทานเล่น',
            'retail_address' => 'ถนน 11',
            'retail_province' => 'พิษณุโลก',
            'retail_district' => 'วังทอง',
            'retail_sub_district' => 'ดินทอง',
            'retail_postcode' => '65130',
            'retail_phone' => '-',
            'retail_contact' => 'line.id',
            'created_at' => now()
        ]);
      
        $id = IdGenerator::generate(['table' => 'retails', 'length' => 10, 'prefix' =>'RETAIL-']);
        
        DB::table('retails')->insert([
            'id' => $id,
            'retail_name' => 'ร้านนิยมกิน',
            'retail_address' => 'ถนน 12',
            'retail_province' => 'พิษณุโลก',
            'retail_district' => 'วังทอง',
            'retail_sub_district' => 'ดินทอง',
            'retail_postcode' => '65130',
            'retail_phone' => '-',
            'retail_contact' => 'contact@example.com',
            'created_at' => now()
        ]);
    }
    
}
