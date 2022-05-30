<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Ak-kawit Tahae',
            'email' => 'akkawit.tah@gmail.com',
            'password' => Hash::make('2112125574'),
        ],
        [
            'name' => 'AvisiaGrace',
            'email' => 'garagrace@gmail.com',
            'password' => Hash::make('2112125574'),
        ]);
    }
}
