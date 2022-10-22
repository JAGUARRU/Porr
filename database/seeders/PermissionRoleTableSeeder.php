<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        
        $employee_permissions = $admin_permissions->filter(function ($permission) {
            return 
                substr($permission->title, 0, 5) != 'user_' && 
                substr($permission->title, 0, 6) != 'truck_';
        });
        Role::findOrFail(2)->permissions()->sync($employee_permissions);


        $driver_permissions = $admin_permissions->filter(function ($permission) {
            return 
                substr($permission->title, 0, 5) != 'user_' && 
                substr($permission->title, 0, 6) != 'truck_' && 
                substr($permission->title, 0, 9) != 'employee_';
        });  
        Role::findOrFail(3)->permissions()->sync($driver_permissions);
    }
}
