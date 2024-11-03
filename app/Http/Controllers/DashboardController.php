<?php

namespace App\Http\Controllers;

use App\Models\Penerimaan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mendapatkan id_user dari pengguna yang login
        $idUser = auth()->user()->id_user;

        // Hitung total penerimaan untuk pengguna yang login
        $totalPenerimaan = Penerimaan::where('id_user', $idUser)->sum('nominal');
        
        // Hitung total pengeluaran untuk pengguna yang login
        $totalPengeluaran = Pengeluaran::where('id_user', $idUser)->sum('nominal');

        // Hitung saldo
        $saldo = $totalPenerimaan - $totalPengeluaran;

        // Kirim data ke view
        return view('admin.dashboard', compact('totalPenerimaan', 'totalPengeluaran', 'saldo'));
    }
}
