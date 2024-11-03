<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User; // Model untuk tabel 'users'
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $users = User::all();

        // Memeriksa apakah pengguna yang sedang login adalah superadmin
        if ($user->role === 'superadmin') {
            return view('superadmin.user.index', compact('user', 'users'));
        } else {
            abort(403, 'Akses tidak diizinkan.');
        }
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->role === 'superadmin') {
            return view('superadmin.user.create', compact('user'));
        } else {
            abort(403, 'Akses tidak diizinkan.');
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
    
        if ($user->role !== 'superadmin') {
            abort(403, 'Akses tidak diizinkan.');
        }
    
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin',
            'cabang' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
        ]);
    
        // Menentukan ID User baru yang unik
        $newIdNumber = 1; // Mulai dari 1
        do {
            $id_user = 'A' . str_pad($newIdNumber, 4, '0', STR_PAD_LEFT);
            $newIdNumber++;
        } while (User::where('id_user', $id_user)->exists());
    
        // Buat user baru dengan ID unik dan hash password
        User::create([
            'id_user' => $id_user,
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password), // Pastikan menggunakan Hash::make
            'role' => $request->role,
            'cabang' => $request->cabang,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);
    
        return redirect()->route('superadmin.user.index')->with('success', 'User berhasil ditambahkan.');
    }
    


    public function edit($id)
    {
        $user = Auth::user();

        if ($user->role !== 'superadmin') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $userToEdit = User::where('id_user', $id)->firstOrFail(); // Mengambil user berdasarkan ID

        return view('superadmin.user.edit', compact('user', 'userToEdit'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->role !== 'superadmin') {
            abort(403, 'Akses tidak diizinkan.');
        }

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,' . $id . ',id_user',
            'role' => 'required|in:admin',
            'cabang' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
        ]);

        $userToUpdate = User::where('id_user', $id)->firstOrFail();
        $userToUpdate->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'role' => $request->role,
            'cabang' => $request->cabang,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('superadmin.user.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        if ($user->role !== 'superadmin') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $userToDelete = User::where('id_user', $id)->firstOrFail();
        $userToDelete->delete();

        return redirect()->route('superadmin.user.index')->with('success', 'User berhasil dihapus.');
    }
}