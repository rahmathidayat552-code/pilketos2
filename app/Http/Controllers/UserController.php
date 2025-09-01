<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // Menampilkan daftar pengguna (admin)
    public function index()
    {
        $users = Admin::all();
        return Inertia::render('Admin/Users/Index', [
            'users' => $users
        ]);
    }

    // Menambah admin baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admin,username', // Menggunakan username
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Admin::create([
            'nama' => $request->nama,
            'username' => $request->username, // Menggunakan username
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    // Memperbarui data admin
    public function update(Request $request, Admin $user)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admin,username,'.$user->id, // Menggunakan username
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->nama = $request->nama;
        $user->username = $request->username; // Menggunakan username

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    // Menghapus admin
    public function destroy(Admin $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}