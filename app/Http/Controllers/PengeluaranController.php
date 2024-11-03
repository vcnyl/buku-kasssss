<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengeluaranController extends Controller
{
    public function index()
    {
        // Filter pengeluaran berdasarkan id_user yang sedang login
        $pengeluaran = Pengeluaran::with(['user', 'kategori'])->where('id_user', Auth::id())->get();
        return view('admin.pengeluaran.index', compact('pengeluaran'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.pengeluaran.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal' => 'required|date',
            'nominal' => 'required|integer',
            'keterangan' => 'nullable|string',
            'id_kategori' => 'required|exists:kategori,id_kategori',
        ]);

        $imageName = 'bukti' . (Pengeluaran::count() + 1) . '.' . $request->bukti->extension();
        $request->bukti->storeAs('public/bukti', $imageName);

        Pengeluaran::create([
            'id_pengeluaran' => 'PU' . str_pad((Pengeluaran::count() + 1), 4, '0', STR_PAD_LEFT),
            'id_user' => Auth::id(), // Set id_user ke user yang login
            'bukti' => $imageName,
            'tanggal' => $request->tanggal,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'id_kategori' => $request->id_kategori,
        ]);

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengeluaran = Pengeluaran::where('id_pengeluaran', $id)->where('id_user', Auth::id())->firstOrFail();
        $kategoris = Kategori::all();
        return view('admin.pengeluaran.edit', compact('pengeluaran', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $pengeluaran = Pengeluaran::where('id_pengeluaran', $id)->where('id_user', Auth::id())->firstOrFail();

        $request->validate([
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal' => 'required|date',
            'nominal' => 'required|integer',
            'keterangan' => 'nullable|string',
            'id_kategori' => 'required|exists:kategori,id_kategori',
        ]);

        if ($request->hasFile('bukti')) {
            Storage::delete('public/bukti/' . $pengeluaran->bukti);
            $imageName = 'bukti' . (Pengeluaran::count() + 1) . '.' . $request->bukti->extension();
            $request->bukti->storeAs('public/bukti', $imageName);
            $pengeluaran->bukti = $imageName;
        }

        $pengeluaran->update([
            'tanggal' => $request->tanggal,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'id_kategori' => $request->id_kategori,
        ]);

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Pengeluaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::where('id_pengeluaran', $id)->where('id_user', Auth::id())->firstOrFail();
        Storage::delete('public/bukti/' . $pengeluaran->bukti);
        $pengeluaran->delete();

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
