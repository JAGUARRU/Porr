<?php

namespace Database\Seeders;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Database\Seeder;
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
  
        DB::table('users')->insert([
            'name' => 'Ak-kawit Tahae',
            'email' => 'akkawit.tah@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456')
        ]);
        
        DB::table('users')->insert([
            'name' => 'AvisiaGrace',
            'email' => 'garagrace@gmail.com',
            'password' => Hash::make('123456')
        ]);
        
        /*
        
        DB::table('users')->insert([
            'name' => 'Ak-kawit Tahae',
            'email' => 'akkawit.tah@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('2112125574'),
            'current_team_id' => Team::factory()->create()->id,
        ]);
        
        DB::table('users')->insert([
            'name' => 'AvisiaGrace',
            'email' => 'garagrace@gmail.com',
            'password' => Hash::make('2112125574'),
            'current_team_id' => Team::factory()->create()->id,
        ]);*/

        // generate test user
        $users = User::factory()->count(5)->create([

        ]);
    }
    
}
