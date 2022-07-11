<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use DB;

class RetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
  
        $id = IdGenerator::generate(['table' => 'retails', 'length' => 10, 'prefix' =>'RETAIL-']);

        DB::table('retails')->insert([
            'id' => $id,
            'retail_name' => 'Shop 1',
            'retail_address' => 'ที่อยู่ร้าน ....',
            'retail_province' => 'สมุทรปราการ',
            'retail_district' => 'เมืองสมุทรปราการ',
            'retail_sub_district' => 'บางเมืองใหม่',
            'retail_postcode' => '10270',
            'retail_phone' => '-',
            'retail_contact' => '-'
        ]);

        $id = IdGenerator::generate(['table' => 'retails', 'length' => 10, 'prefix' =>'RETAIL-']);
        
        DB::table('retails')->insert([
            'id' => $id,
            'retail_name' => 'Shop 2',
            'retail_address' => 'ที่อยู่ร้าน ....',
            'retail_province' => 'สมุทรปราการ',
            'retail_district' => 'เมืองสมุทรปราการ',
            'retail_sub_district' => 'ปากน้ำ',
            'retail_postcode' => '10270',
            'retail_phone' => '-',
            'retail_contact' => '-'
        ]);
      
        $id = IdGenerator::generate(['table' => 'retails', 'length' => 10, 'prefix' =>'RETAIL-']);
        
        DB::table('retails')->insert([
            'id' => $id,
            'retail_name' => 'Shop 3',
            'retail_address' => 'ที่อยู่ร้าน ....',
            'retail_province' => 'สมุทรปราการ',
            'retail_district' => 'เมืองสมุทรปราการ',
            'retail_sub_district' => 'ท้ายบ้าน',
            'retail_postcode' => '10280',
            'retail_phone' => '-',
            'retail_contact' => '-'
        ]);
        
    }
    
}
