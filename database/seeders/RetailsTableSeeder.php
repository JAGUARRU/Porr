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
            'retail_province' => 'พิษณุโลก',
            'retail_district' => 'นครไทย',
            'retail_sub_district' => 'นาบัว',
            'retail_postcode' => '65120',
            'retail_phone' => '-',
            'retail_contact' => '-'
        ]);

        $id = IdGenerator::generate(['table' => 'retails', 'length' => 10, 'prefix' =>'RETAIL-']);
        
        DB::table('retails')->insert([
            'id' => $id,
            'retail_name' => 'Shop 2',
            'retail_address' => 'ที่อยู่ร้าน ....',
            'retail_province' => 'พิษณุโลก',
            'retail_district' => 'นครไทย',
            'retail_sub_district' => 'นาบัว',
            'retail_postcode' => '65120',
            'retail_phone' => '-',
            'retail_contact' => '-'
        ]);
      
        $id = IdGenerator::generate(['table' => 'retails', 'length' => 10, 'prefix' =>'RETAIL-']);
        
        DB::table('retails')->insert([
            'id' => $id,
            'retail_name' => 'Shop 3',
            'retail_address' => 'ที่อยู่ร้าน ....',
            'retail_province' => 'พิษณุโลก',
            'retail_district' => 'วังทอง',
            'retail_sub_district' => 'ดินทอง',
            'retail_postcode' => '65130',
            'retail_phone' => '-',
            'retail_contact' => '-'
        ]);
        
    }
    
}
