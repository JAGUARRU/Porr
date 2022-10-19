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
            'retail_address' => '100 หมู่ที่ 3 บ้านโนน',
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
            'retail_address' => '60/400 หมู่ 11 (ข้างมินิบิ๊กซี)',
            'retail_province' => 'พิษณุโลก',
            'retail_district' => 'เนินมะปราง',
            'retail_sub_district' => 'บ้านมุง',
            'retail_postcode' => '65190',
            'retail_phone' => '0646653222',
            'retail_contact' => '-',
            'created_at' => now()
        ]);
      
        $id = IdGenerator::generate(['table' => 'retails', 'length' => 10, 'prefix' =>'RETAIL-']);
        
        DB::table('retails')->insert([
            'id' => $id,
            'retail_name' => 'ร้านทานเล่น',
            'retail_address' => '69/3 แยก 3 หมู่ 4 แยกการไฟฟ้าเลี้ยวขวา',
            'retail_province' => 'พิษณุโลก',
            'retail_district' => 'วัดโบสถ์',
            'retail_sub_district' => 'วัดโบสถ์',
            'retail_postcode' => '65160',
            'retail_phone' => '0881671347',
            'retail_contact' => '0881671347',
            'created_at' => now()
        ]);
      
        $id = IdGenerator::generate(['table' => 'retails', 'length' => 10, 'prefix' =>'RETAIL-']);
        
        DB::table('retails')->insert([
            'id' => $id,
            'retail_name' => 'ร้านนิยมกิน',
            'retail_address' => '112/150 ซ.ดินทอง 13 ปากซอยเป็นร้านเติมลมยาง เลี้ยวซ้ายเข้ามา ร้านอยู่ซ้ายมือ ',
            'retail_province' => 'พิษณุโลก',
            'retail_district' => 'วังทอง',
            'retail_sub_district' => 'ดินทอง',
            'retail_postcode' => '65130',
            'retail_phone' => '0895209220',
            'retail_contact' => '@kinkin',
            'created_at' => now()
        ]);

        $id = IdGenerator::generate(['table' => 'retails', 'length' => 10, 'prefix' =>'RETAIL-']);
        
        DB::table('retails')->insert([
            'id' => $id,
            'retail_name' => 'ร้านไม้ตาย',
            'retail_address' => '19/11 ถ.ป่าแดง ซ.เล้าไก่ 39 แยก 5',
            'retail_province' => 'พิษณุโลก',
            'retail_district' => 'ชาติตระการ',
            'retail_sub_district' => 'ป่าแดง',
            'retail_postcode' => '65170',
            'retail_phone' => '0625307012',
            'retail_contact' => '.flare',
            'created_at' => now()
        ]);
    }
    
}
