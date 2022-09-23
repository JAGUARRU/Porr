<?php

namespace Database\Seeders;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Database\Seeder;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\User;
use App\Models\Team;
use DB;
use Hash;
use Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = IdGenerator::generate(['table' => 'users', 'length' => 8, 'field' => 'empId', 'prefix' =>'EMP-']);

        DB::table('users')->insert([
            'name' => 'Ak-kawit Tahae',
            'email' => 'akkawit.tah@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'empId' => $id
        ]);
        
        $id = IdGenerator::generate(['table' => 'users', 'length' => 8, 'field' => 'empId', 'prefix' =>'EMP-']);

        DB::table('users')->insert([
            'name' => 'AvisiaGrace',
            'email' => 'garagrace@gmail.com',
            'password' => Hash::make('123456'),
            'empId' => $id
        ]);
        
        // generate test user
        $users = User::factory()->count(5)->create([

        ]);

        $users = User::factory()->count(1)->create([
            "inactive" => true
        ]);
    }
    
}
