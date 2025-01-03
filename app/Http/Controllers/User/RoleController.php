<?php

namespace App\Http\Controllers\User;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        // Ambil semua role beserta jumlah permission
        $roles = Role::withCount('permissions')->get();

        return Inertia::render('Role/Index', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        $permissions = Permission::all();

        return Inertia::render('Role/Create', [
            'permissions' => $permissions,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            //code...
            Role::create([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);

            return redirect()->route('role')->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('role')->with('error', 'Role create failed.');
        }
    }

    public function show($id)
    {
        $role = Role::with('permissions')
            ->findOrFail($id);

        return Inertia::render('Role/View', [
            'role' => $role,
        ]);
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        // $permissions = Permission::all();

        return Inertia::render('Role/Edit', [
            'role' => $role,
            // 'permissions' => $permissions,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = Role::findOrFail($id);

        try {
            $role->name = $request->name;
            $role->save();

            return redirect()->route('role')->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('role')->with('error', 'Role update failed.');
        }

        return redirect()->route('role')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        try {
            $role->delete();

            return redirect()->route('role')->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('role')->with('error', 'Role delete failed.');
        }
    }
}
