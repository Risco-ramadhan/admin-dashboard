<?php

namespace App\Http\Controllers\User;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->roles->pluck('name')->join(', '), // Gabungkan nama peran dengan koma
                ];
            });

        $data = [
            'users' => $users,
        ];

        return Inertia::render('User/Index', $data);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $roles = $user->getRoleNames();
        return Inertia::render('User/View', [ // Render view yang berbeda
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        // Ambil semua role yang tersedia
        $roles = Role::where('name', '!=', 'super admin')
            ->get();

        // Menampilkan halaman create dengan data role
        return Inertia::render('User/Create', [
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'roles' => 'required|array|min:1',
            // 'roles.*' => 'exists:roles,name', // Pastikan role yang dipilih ada di tabel roles
        ]);

        // Buat pengguna baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        foreach ($validated['roles'] as $role) {
            $user->assignRole($role['name']);
        }

        // Redirect atau memberikan response
        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id); // Load user with roles
        $roles = Role::all();

        // Get selected roles as an array of IDs
        $userRoles = $user->roles;

        return Inertia::render('User/Edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'assigned_roles' => $userRoles, // Pass the role IDs to the frontend
            ],
            'roles' => $roles->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                ];
            }),
        ]);
    }


    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            // 'password' => 'nullable|string|min:8', // Password is optional for update
            'roles' => 'required|array|min:1',
            // 'roles.*' => 'exists:roles,name', // Ensure selected roles exist in the roles table
        ]);

        // Cari pengguna yang ingin diupdate
        $user = User::findOrFail($id);

        // Update data pengguna
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        $user->save();

        $user->syncRoles([]);

        foreach ($validated['roles'] as $value) {
            // Find the role by ID
            $role = Role::findOrFail($value['id']); // Ensure the role exists
            // Assign the role to the user
            $user->assignRole($role->name);
        } // This ensures roles are synced correctly

        // Redirect atau memberikan response
        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }



    public function destroy($id)
    {
        // Ambil pengguna berdasarkan ID
        $user = User::findOrFail($id);

        $user->syncRoles([]);
        // Hapus pengguna
        $user->delete();

        // Redirect atau memberikan response
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
}
