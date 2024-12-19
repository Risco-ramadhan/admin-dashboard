<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;


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
