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
        $dashboardUuid = Str::uuid()->toString();
        $managementUuid = Str::uuid()->toString();
        $userUuid = Str::uuid()->toString();
        $menus = [
            [
                'id' => $dashboardUuid,
                'menu_label' => 'Dashboard',
                'menu_route' => 'dashboard',
                'menu_level' => 1,
                'menu_parent' => null,
                'menu_permission' => null,
                'menu_is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid()->toString(),
                'menu_label' => 'Dashboard SM',
                'menu_route' => null,
                'menu_level' => 2,
                'menu_parent' => $dashboardUuid,
                'menu_permission' => null,
                'menu_is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>  Str::uuid()->toString(),
                'menu_label' => 'Dashboard ITAM',
                'menu_route' => null,
                'menu_level' => 2,
                'menu_parent' => $dashboardUuid,
                'menu_permission' => null,
                'menu_is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // User Management
            [
                'id' => $managementUuid,
                'menu_label' => 'Management',
                'menu_route' => null,
                'menu_level' => 2,
                'menu_parent' => $dashboardUuid,
                'menu_permission' => null,
                'menu_is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => $userUuid,
                'menu_label' => 'User',
                'menu_route' => null,
                'menu_level' => 3,
                'menu_parent' => $managementUuid,
                'menu_permission' => null,
                'menu_is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>  Str::uuid()->toString(),
                'menu_label' => 'user management',
                'menu_route' => null,
                'menu_level' => 4,
                'menu_parent' => $userUuid,
                'menu_permission' => null,
                'menu_is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>  Str::uuid()->toString(),
                'menu_label' => 'Role Management',
                'menu_route' => 'role',
                'menu_level' => 4,
                'menu_parent' => $userUuid,
                'menu_permission' => null,
                'menu_is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>  Str::uuid()->toString(),
                'menu_label' => 'Menu Management',
                'menu_route' => 'menu',
                'menu_level' => 4,
                'menu_parent' => $userUuid,
                'menu_permission' => null,
                'menu_is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' =>  Str::uuid()->toString(),
                'menu_label' => 'Menu Permission',
                'menu_route' => 'permission.menu',
                'menu_level' => 4,
                'menu_parent' => $userUuid,
                'menu_permission' => null,
                'menu_is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        DB::table('menus')->insert($menus);
    }
}
