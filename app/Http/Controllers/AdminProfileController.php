<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AdminProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('admin.profile', compact('user'));
        } else {
            abort(403, 'Akses tidak diizinkan.');
        }
    }

    public function edit()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('admin.editProfile', compact('user'));
        } else {
            abort(403, 'Akses tidak diizinkan.');
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            abort(403, 'Akses tidak diizinkan.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id_user . ',id_user',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:15',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update user details
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->alamat = $request->alamat;
        $user->no_hp = $request->no_hp;

        if ($request->hasFile('foto')) {
            // Delete old photo if it exists
            if ($user->foto) {
                Storage::delete($user->foto);
            }
            // Store new photo
            $user->foto = $request->file('foto')->store('profile_pictures');
        }

        $user->save();

        return redirect()->route('admin.profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
