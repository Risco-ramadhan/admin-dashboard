<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $menus = [
            [
                'id' => Str::uuid()->toString(),
                'menu_label' => 'Dashboard',
                'menu_route' => 'dashboard.index',
                'menu_level' => 1,
                'menu_parent' => null,
                'menu_permission' => null,
                'menu_is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'menu_label' => 'Users Management',
                'menu_route' => null,
                'menu_level' => 1,
                'menu_parent' => null,
                'menu_permission' => null,
                'menu_is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'menu_label' => 'Add User',
                'menu_route' => 'users.create',
                'menu_level' => 2,
                'menu_parent' => null, // Replace with the 'Users Management' UUID if hierarchical relationship is established.
                'menu_permission' => null,
                'menu_is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'menu_label' => 'Settings',
                'menu_route' => 'settings.index',
                'menu_level' => 1,
                'menu_parent' => null,
                'menu_permission' => null,
                'menu_is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('menus')->insert($menus);
    }
}
