<?php

namespace App\Http\Controllers\Menu;

use Inertia\Inertia;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function index()
    {
        // Ambil semua pengguna
        $permissions = Permission::all();
        $data = [
            'permissions' => $permissions
        ];
        return Inertia::render('Menu/Permission-menu', $data);
    }
}
