<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class PositionUserTableSeeder extends Seeder
{
    public function run()
    {
        User::findOrFail(1)->positions()->sync([1, 2]);
        User::findOrFail(2)->positions()->sync(2);
        User::findOrFail(3)->positions()->sync(2);
        User::findOrFail(4)->positions()->sync(2);
        User::findOrFail(5)->positions()->sync(2);
    }
}
