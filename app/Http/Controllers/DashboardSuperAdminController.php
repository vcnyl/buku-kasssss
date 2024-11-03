<?php

namespace App\Http\Controllers;

use App\Models\User; // Pastikan User model di-import
use App\Models\Penerimaan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class DashboardSuperAdminController extends Controller
{
    public function index()
    {
        // Ambil semua admin yang memiliki peran admin
        $admins = User::where('role', 'admin')->get(); // Ganti 'role' sesuai dengan kolom di tabel users

        $data = [];

        foreach ($admins as $admin) {
            // Hitung total penerimaan dan pengeluaran per admin
            $totalPenerimaan = Penerimaan::where('id_user', $admin->id_user)->sum('nominal');
            $totalPengeluaran = Pengeluaran::where('id_user', $admin->id_user)->sum('nominal');
            $saldo = $totalPenerimaan - $totalPengeluaran;

            $data[] = [
                'admin' => $admin,
                'totalPenerimaan' => $totalPenerimaan,
                'totalPengeluaran' => $totalPengeluaran,
                'saldo' => $saldo,
            ];
        }

        return view('superadmin.dashboard', compact('data'));
    }
}
