<?php

namespace Database\Seeders;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Team;
use DB;
use Hash;
use Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
  
       //  User::factory()->count(20)->create();
        
        $users = User::factory()->count(5)->create([
            'password' => Hash::make('2112125574'),
            'current_team_id' => Team::factory()->create()->id
        ]);

        DB::table('users')->insert([
            'name' => 'Ak-kawit Tahae',
            'email' => 'akkawit.tah@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('2112125574'),
            'remember_token' => Str::random(10),
            'current_team_id' => Team::factory()->create()->id,
        ]);
        
        DB::table('users')->insert([
            'name' => 'AvisiaGrace',
            'email' => 'garagrace@gmail.com',
            'password' => Hash::make('2112125574'),
            'remember_token' => Str::random(10),
            'current_team_id' => Team::factory()->create()->id,
        ]);
    }
    
}
