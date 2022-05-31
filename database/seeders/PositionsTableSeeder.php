<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    public function run()
    {
        $positions = [
            [
                'id'    => 1,
                'title' => 'Manager',
            ],
            [
                'id'    => 2,
                'title' => 'Driver',
            ],
        ];

        Position::insert($positions);
    }
}
