<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = [
            // Dashboard Permissions
            [
                'id' => Str::uuid()->toString(),
                'name' => 'view-dashboard-main',
                'guard_name' => 'web',
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'view-dashboard-SM',
                'guard_name' => 'web',
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'view-dashboard-ITAM',
                'guard_name' => 'web',
            ],

            // Management Permissions
            [
                'id' => Str::uuid()->toString(),
                'name' => 'view-management-main',
                'guard_name' => 'web',
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'view-user-submain',
                'guard_name' => 'web',
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'view-user-management',
                'guard_name' => 'web',
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'view-role-management',
                'guard_name' => 'web',
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'view-menu-management',
                'guard_name' => 'web',
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'view-menu-permission',
                'guard_name' => 'web',
            ],
        ];
        DB::table('permissions')->insert($permission);
    }
}
