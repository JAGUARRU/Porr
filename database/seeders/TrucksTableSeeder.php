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
            'plateNumber' => 'กขค 123',
            'status' => 'พร้อมใช้งาน',
            'user_id' => null
        ]);

        $id = IdGenerator::generate(['table' => 'trucks', 'length' => 6, 'prefix' =>'T-']);
        
        DB::table('trucks')->insert([
            'id' => $id,
            'plateNumber' => 'ABC 123',
            'status' => 'พร้อมใช้งาน',
            'user_id' => null
        ]);
      
        $id = IdGenerator::generate(['table' => 'trucks', 'length' => 6, 'prefix' =>'T-']);
        
        DB::table('trucks')->insert([
            'id' => $id,
            'plateNumber' => 'สว 123',
            'status' => 'พร้อมใช้งาน',
            'user_id' => null
        ]);
    
        $id = IdGenerator::generate(['table' => 'trucks', 'length' => 6, 'prefix' =>'T-']);
        
        DB::table('trucks')->insert([
            'id' => $id,
            'plateNumber' => 'กจ 123',
            'status' => 'พร้อมใช้งาน',
            'user_id' => 1
        ]);
    }
    
}
