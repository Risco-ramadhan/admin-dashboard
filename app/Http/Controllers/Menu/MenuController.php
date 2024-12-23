<?php

namespace App\Http\Controllers\Menu;

use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::all();
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
        // Ambil semua izin untuk ditampilkan sebagai checkbox
        $permissions = Permission::all();
        return Inertia::render('Menu/Create', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_label' => 'required|string|max:255',
            'menu_route' => 'nullable|string|max:255',
            'menu_level' => 'required|integer',
            'menu_parent' => 'nullable|uuid',
            'menu_permission' => 'nullable|string|max:255',
            'menu_is_active' => 'required|boolean',
        ]);

        $menu = Menu::create($validated);

        return redirect()->route('menu.index')->with('success', 'Menu created successfully.');
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