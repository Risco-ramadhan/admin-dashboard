<?php

namespace App\Http\Controllers\Menu;

use App\Models\Menu;
use Inertia\Inertia;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('permission')
            ->get()
            ->map(function ($menu) {
                return [
                    'id' => $menu->id,
                    'menu_label' => $menu->menu_label,
                    'menu_route' => $menu->menu_route,
                    'menu_level' => $menu->menu_level,
                    'menu_permission' => $menu->permission->name ?? 'No Permission', // Extract permission name
                    'menu_is_active' => $menu->menu_is_active ? 'Active' : 'Inactive', // Format active status
                ];
            });
        $data = [
            'menus' => $menus
        ];
        return Inertia::render('Menu/Index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menus = Menu::select('id', 'menu_label')->get();

        $permissions = Permission::where('name', 'ILIKE', '%menu%')
            ->get();

        return Inertia::render('Menu/Create', [
            'permissions' => $permissions,
            'parent_menus' => $menus
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'menu_label' => 'required|string|max:255',
            'menu_route' => 'nullable|string|max:255',
            'menu_level' => 'required|integer',
            'menu_parent' => 'nullable|uuid',
            'menu_permission' => 'nullable|array|max:255',
            'menu_is_active' => 'required|boolean',
        ]);

        // Prepare the menu permission ID by extracting only the ID from the nested object
        if (isset($validated['menu_permission']) && is_array($validated['menu_permission'])) {
            $validated['menu_permission'] = $validated['menu_permission']['id'] ?? null;
        }

        try {
            $menu = Menu::create($validated);

            return redirect()->route('menu')->with('success', 'Menu created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('menu')->with('error', 'Menu create failed.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $menu = Menu::with('permissions')->findOrFail($id);
        $menu = Menu::findOrFail($id);
        return Inertia::render('Menu/View', [
            'menu' => $menu,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $permissions = Permission::all();

        return Inertia::render('Menu/Edit', [
            'menu' => $menu,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'menu_label' => 'required|string|max:255',
            'menu_route' => 'nullable|string|max:255',
            'menu_level' => 'required|integer',
            'menu_parent' => 'nullable|uuid',
            'menu_permission' => 'nullable|string|max:255',
            'menu_is_active' => 'required|boolean',
        ]);

        try {
            $menu = Menu::findOrFail($id);
            $menu->update($validated);

            // Jika update berhasil, kirimkan success message ke frontend
            return Inertia::render('Menu/EditMenu', [
                'success' => 'Menu updated successfully.',
            ]);
        } catch (\Exception $e) {
            // Jika ada kesalahan, kirimkan error message ke frontend
            return Inertia::render('Menu/EditMenu', [
                'errors' => ['error' => 'Menu update failed.'],
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu deleted successfully.');
    }
}
