<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Eloquent::unguard();

        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,

            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,

            RetailsTableSeeder::class,
            OrderTableSeeder::class,
            TrucksTableSeeder::class
        ]);
        
        $this->command->info('main table seeded!');

        $path = 'app/developer_docs/tambons.sql';
        
        DB::unprepared(file_get_contents($path));

        $this->command->info('tambons table seeded!');

        DB::statement('DELETE FROM `tambons` WHERE `province` != "พิษณุโลก"');

        $this->command->info('only phitsanulok data seeded!');
    }
}
