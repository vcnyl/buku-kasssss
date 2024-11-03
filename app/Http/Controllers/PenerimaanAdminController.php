<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Penerimaan;

class PenerimaanAdminController extends Controller
{
    public function index()
    {
        // Ambil data penerimaan sesuai dengan akun yang sedang login
        $penerimaan = Penerimaan::where('id_user', Auth::id())->get();
        return view('admin.penerimaan.index', compact('penerimaan'));
    }

    public function create()
    {
        return view('admin.penerimaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal' => 'required|date',
            'nominal' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        $imageName = 'gambar' . (Penerimaan::count() + 1) . '.' . $request->bukti->extension();
        $request->bukti->storeAs('public/bukti', $imageName);

        Penerimaan::create([
            'id_penerimaan' => 'PA' . str_pad((Penerimaan::count() + 1), 4, '0', STR_PAD_LEFT),
            'id_user' => Auth::id(),
            'bukti' => $imageName,
            'tanggal' => $request->tanggal,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.penerimaan.index')->with('success', 'Penerimaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $penerimaan = Penerimaan::where('id_penerimaan', $id)->where('id_user', Auth::id())->firstOrFail();
        return view('admin.penerimaan.edit', compact('penerimaan'));
    }

    public function update(Request $request, $id)
    {
        $penerimaan = Penerimaan::where('id_penerimaan', $id)->where('id_user', Auth::id())->firstOrFail();

        $request->validate([
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal' => 'required|date',
            'nominal' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('bukti')) {
            Storage::delete('public/bukti/' . $penerimaan->bukti);
            $imageName = 'gambar' . (Penerimaan::count() + 1) . '.' . $request->bukti->extension();
            $request->bukti->storeAs('public/bukti', $imageName);
            $penerimaan->bukti = $imageName;
        }

        $penerimaan->update([
            'tanggal' => $request->tanggal,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.penerimaan.index')->with('success', 'Penerimaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penerimaan = Penerimaan::where('id_penerimaan', $id)->where('id_user', Auth::id())->firstOrFail();
        Storage::delete('public/bukti/' . $penerimaan->bukti);
        $penerimaan->delete();

        return redirect()->route('admin.penerimaan.index')->with('success', 'Penerimaan berhasil dihapus.');
    }
}
