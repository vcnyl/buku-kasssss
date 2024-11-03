<?php

namespace App\Http\Controllers;

use App\Models\Penerimaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenerimaanController extends Controller
{
    public function index()
    {
        $penerimaan = Penerimaan::with('user')->get();
        return view('superadmin.penerimaan.index', compact('penerimaan'));
    }

    public function create()
    {
        $adminUsers = User::where('role', 'admin')->get();
        return view('superadmin.penerimaan.create', compact('adminUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal' => 'required|date',
            'nominal' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        // Mengganti nama file gambar
        $imageName = 'gambar' . (Penerimaan::count() + 1) . '.' . $request->bukti->extension();
        
        // Simpan gambar ke folder storage/app/public/bukti
        $request->bukti->storeAs('public/bukti', $imageName);

        Penerimaan::create([
            'id_penerimaan' => 'PA' . str_pad((Penerimaan::count() + 1), 4, '0', STR_PAD_LEFT),
            'id_user' => $request->id_user,
            'bukti' => $imageName,
            'tanggal' => $request->tanggal,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('superadmin.penerimaan.index')->with('success', 'Penerimaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $penerimaan = Penerimaan::findOrFail($id);
        $adminUsers = User::where('role', 'admin')->get();
        return view('superadmin.penerimaan.edit', compact('penerimaan', 'adminUsers'));
    }

    public function update(Request $request, $id)
    {
        $penerimaan = Penerimaan::findOrFail($id);

        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal' => 'required|date',
            'nominal' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('bukti')) {
            Storage::delete('public/bukti/' . $penerimaan->bukti); // Hapus file yang lama
            $imageName = 'gambar' . (Penerimaan::count() + 1) . '.' . $request->bukti->extension();
            $request->bukti->storeAs('public/bukti', $imageName); // Simpan gambar baru
            $penerimaan->bukti = $imageName;
        }

        $penerimaan->update([
            'id_user' => $request->id_user,
            'tanggal' => $request->tanggal,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('superadmin.penerimaan.index')->with('success', 'Penerimaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penerimaan = Penerimaan::findOrFail($id);
        Storage::delete('public/bukti/' . $penerimaan->bukti); // Hapus file bukti
        $penerimaan->delete();

        return redirect()->route('superadmin.penerimaan.index')->with('success', 'Penerimaan berhasil dihapus.');
    }
}
