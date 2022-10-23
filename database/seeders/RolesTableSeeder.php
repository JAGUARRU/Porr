<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'ผู้ดูแลระบบ',
            ],
            [
                'id'    => 2,
                'title' => 'พนักงาน',
            ],
            [
                'id'    => 3,
                'title' => 'พนักงานส่งสินค้า',
            ]
        ];

        Role::insert($roles);
    }
}
