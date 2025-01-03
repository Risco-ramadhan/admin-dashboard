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
        // Ambil semua pengguna
        $users = User::all();

        // Buat array untuk menyimpan data pengguna beserta role-nya
        $userWithRoles = [];

        foreach ($users as $user) {
            // Ambil nama role untuk setiap pengguna
            $roles = $user->getRoleNames()->toArray(); // Mengubah role names menjadi array
            $userWithRoles[] = [
                'id' => $user->id,
                'name' => $user->name, // Menyimpan nama pengguna
                'email' => $user->email, // Menyimpan nama pengguna
                'roles' => $roles // Menyimpan role pengguna
            ];
        }

        // Menampilkan hasil
        $data = [
            'users' => $userWithRoles
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
        $roles = Role::all();

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
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name', // Pastikan role yang dipilih ada di tabel roles
        ]);

        // Buat pengguna baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        // Assign roles ke pengguna
        $user->syncRoles($validated['roles']);

        // Redirect atau memberikan response
        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();

        return Inertia::render('User/Edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles->pluck('name')->toArray(),
            ],
            'allRoles' => $roles->map(function ($role) {
                return ['id' => $role->id, 'name' => $role->name];
            }),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name',
        ]);
        $user = User::findOrFail($id);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $user->syncRoles($validated['roles']);

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }


    public function destroy($id)
    {
        // Ambil pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Hapus pengguna
        $user->delete();

        // Redirect atau memberikan response
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }

    public function getDataUser()
    {
        // Ambil semua pengguna
        $users = User::all();
        // Buat array untuk menyimpan data pengguna beserta role-nya
        $userWithRoles = [];

        foreach ($users as $user) {
            // Ambil nama role untuk setiap pengguna
            $roles = $user->getRoleNames()->toArray(); // Mengubah role names menjadi array
            $userWithRoles[] = [
                'user' => $user->name, // Menyimpan nama pengguna
                'email' => $user->email, // Menyimpan email pengguna
                'roles' => $roles // Menyimpan role pengguna
            ];
        }

        // Kembalikan data sebagai response JSON
        return response()->json([
            'users' => $userWithRoles
        ]);
    }
}
