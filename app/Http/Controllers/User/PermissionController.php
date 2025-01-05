<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua pengguna
        $permissions = Permission::all();
        $data = [
            'permissions' => $permissions
        ];
        return Inertia::render('Permission/Index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Permission/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            Permission::create([
                'name' => $request->name
            ]);

            return redirect()->route('permission')->with('success', 'Permission created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('permission')->with('error', 'Permission create failed.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return Inertia::render('Permission/Edit', [
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $permission->update($request->only('name'));

            return redirect()->route('permission')->with('success', 'Permission updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('permission')->with('error', 'Permission update failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        try {
            $permission->delete();

            return redirect()->route('permission')->with('success', 'Permission deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('permission')->with('error', 'Permission delete failed.');
        }
    }
}
