<?php

namespace App\Http\Controllers\User;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        // Ambil semua role beserta jumlah permission
        $roles = Role::withCount('permissions')->get();

        $data = [
            'roles' => $roles
        ];
        return Inertia::render('Role/Index', $data);
    }

    public function show($id)
    {
        // Ambil role berdasarkan ID beserta daftar permissions-nya
        // $role = Role::with('permissions')->findOrFail($id);
        $role = Role::findOrFail($id);

        return Inertia::render('Role/View', [
            'role' => $role
        ]);
    }

    public function edit($id)
    {
        // Ambil role berdasarkan ID
        $role = Role::findOrFail($id);
        // Ambil semua permission
        $permissions = Permission::all();
        return Inertia::render('Role/Edit', [
            'role' => $role,
            'permissions' => $permissions,
            'assigned_permissions' => $role->permissions->pluck('id'),
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Ambil role
        $role = Role::findOrFail($id);

        // Sinkronisasi permission
        $role->syncPermissions($request->permissions);
        return redirect()->route('role')->with('success', 'Role updated successfully.');
    }
}