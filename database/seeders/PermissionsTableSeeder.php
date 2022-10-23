<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_access',
            ],
            [
                'id'    => 2,
                'title' => 'employee_view_access',
            ],
            [
                'id'    => 3,
                'title' => 'employee_product_add_access',
            ],
            [
                'id'    => 4,
                'title' => 'employee_product_category_add_access',
            ],
            [
                'id'    => 5,
                'title' => 'truck_access',
            ],
            [
                'id'    => 6,
                'title' => 'employee_truck_add_access',
            ],
            [
                'id'    => 7,
                'title' => 'employee_order_add_access',
            ],
            [
                'id'    => 8,
                'title' => 'employee_truck_load_access',
            ],
            [
                'id'    => 9,
                'title' => 'employee_truck_print_access',
            ],
            [
                'id'    => 10,
                'title' => 'user_transport_edit_access',
            ],
            [
                'id'    => 11,
                'title' => 'employee_transport_cancel_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_product_edit_access',
            ],
            [
                'id'    => 13,
                'title' => 'user_product_category_edit_access'
            ],
            [
                'id'    => 14,
                'title' => 'employee_retail_add_access',
            ],
            [
                'id'    => 15,
                'title' => 'user_retail_edit_access'
            ],
            [
                'id'    => 16,
                'title' => 'user_order_edit_access',
            ],
            [
                'id'    => 17,
                'title' => 'user_report_print_access',
            ]
        ];

        Permission::insert($permissions);
    }
}
