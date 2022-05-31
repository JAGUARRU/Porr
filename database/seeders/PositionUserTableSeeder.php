<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PositionUserTableSeeder extends Seeder
{
    public function run()
    {
        User::findOrFail(1)->positions()->sync(1);
        User::findOrFail(2)->positions()->sync(2);
    }
}
