<?php

namespace App\Http\Controllers;

use App\Models\Penerimaan;
use App\Models\Pengeluaran;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dompdf\Dompdf;

class LaporanController extends Controller
{
    public function laporan(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user
        $cabang = $user->cabang; // Get the branch (cabang) from the authenticated user

        // Fetch input values from request
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $kategoriId = $request->input('kategori_id');

        // Retrieve list of categories
        $kategoriList = Kategori::all();

        // Retrieve Penerimaan data based on filters
        $penerimaanQuery = Penerimaan::with('kategori')
            ->where('id_user', $user->id_user);

        if ($tanggalMulai && $tanggalAkhir) {
            $penerimaanQuery->whereBetween('tanggal', [Carbon::parse($tanggalMulai), Carbon::parse($tanggalAkhir)]);
        }

        // Only include Penerimaan if "Semua Kategori" is selected
        if (!$kategoriId) { // If no category is selected
            $penerimaanData = $penerimaanQuery->get();
        } else {
            $penerimaanData = collect(); // If a category is selected, return empty collection
        }

        // Retrieve Pengeluaran data based on filters
        $pengeluaranQuery = Pengeluaran::with('kategori')
            ->where('id_user', $user->id_user);

        if ($tanggalMulai && $tanggalAkhir) {
            $pengeluaranQuery->whereBetween('tanggal', [Carbon::parse($tanggalMulai), Carbon::parse($tanggalAkhir)]);
        }

        // Apply category filter only to Pengeluaran
        if ($kategoriId) {
            $pengeluaranQuery->where('id_kategori', $kategoriId); // Filter by category only for Pengeluaran
        }

        $pengeluaranData = $pengeluaranQuery->get();

        // Combine both data sets for the report
        $laporan = $penerimaanData->map(function ($data) {
            return (object) [
                'tanggal' => $data->tanggal,
                'kategori' => 'Fawzzan', // Changed to 'N/A' if not available
                'penerimaan' => $data->nominal,
                'pengeluaran' => null,
                'keterangan' => $data->keterangan,
            ];
        })->merge(
            $pengeluaranData->map(function ($data) {
                return (object) [
                    'tanggal' => $data->tanggal,
                    'kategori' => optional($data->kategori)->nama_kategori ?? '-', // Changed to '-' if not available
                    'penerimaan' => null,
                    'pengeluaran' => $data->nominal,
                    'keterangan' => $data->keterangan,
                ];
            })
        );

        // Sort by date for better readability
        $laporan = $laporan->sortBy('tanggal');

        // Calculate total penerimaan and pengeluaran
        $totalPenerimaan = $penerimaanData->sum('nominal');
        $totalPengeluaran = $pengeluaranData->sum('nominal');

        // Calculate overall totals (Optional)
        $overallPenerimaan = Penerimaan::where('id_user', $user->id_user)->sum('nominal');
        $overallPengeluaran = Pengeluaran::where('id_user', $user->id_user)->sum('nominal');
        $overallTotal = $overallPenerimaan - $overallPengeluaran;

        // Return the view with the required data
        return view('admin.laporan.index', compact(
            'kategoriList',
            'laporan',
            'user',
            'totalPenerimaan',
            'totalPengeluaran',
            'kategoriId',
            'overallTotal',
            'tanggalMulai', // Include tanggalMulai for the view
            'tanggalAkhir', // Include tanggalAkhir for the view
            'cabang' // Pass cabang to the view
        ));
    }

    public function downloadPDF(Request $request)
    {
        $user = auth()->user();
        $cabang = $user->cabang; // Get the branch (cabang) from the authenticated user

        // Fetch input values from request
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $kategoriId = $request->input('kategori_id');

        // Retrieve list of categories
        $kategoriList = Kategori::all();

        // Fetch Penerimaan data based on filters
        $penerimaanQuery = Penerimaan::with('kategori')
            ->where('id_user', $user->id_user);

        if ($tanggalMulai && $tanggalAkhir) {
            $penerimaanQuery->whereBetween('tanggal', [Carbon::parse($tanggalMulai), Carbon::parse($tanggalAkhir)]);
        }

        if (!$kategoriId) {
            $penerimaanData = $penerimaanQuery->get();
        } else {
            $penerimaanData = collect();
        }

        // Fetch Pengeluaran data based on filters
        $pengeluaranQuery = Pengeluaran::with('kategori')
            ->where('id_user', $user->id_user);

        if ($tanggalMulai && $tanggalAkhir) {
            $pengeluaranQuery->whereBetween('tanggal', [Carbon::parse($tanggalMulai), Carbon::parse($tanggalAkhir)]);
        }

        if ($kategoriId) {
            $pengeluaranQuery->where('id_kategori', $kategoriId);
        }

        $pengeluaranData = $pengeluaranQuery->get();

        // Combine data for the report
        $laporan = $penerimaanData->map(function ($data) {
            return (object) [
                'tanggal' => $data->tanggal,
                'kategori' => 'Fawzzan',
                'penerimaan' => $data->nominal,
                'pengeluaran' => null,
                'keterangan' => $data->keterangan,
            ];
        })->merge(
            $pengeluaranData->map(function ($data) {
                return (object) [
                    'tanggal' => $data->tanggal,
                    'kategori' => optional($data->kategori)->nama_kategori ?? '-',
                    'penerimaan' => null,
                    'pengeluaran' => $data->nominal,
                    'keterangan' => $data->keterangan,
                ];
            })
        )->sortBy('tanggal');

        // Calculate totals
        $totalPenerimaan = $penerimaanData->sum('nominal');
        $totalPengeluaran = $pengeluaranData->sum('nominal');
        $overallTotal = $totalPenerimaan + $totalPengeluaran;

        // Load the view into DomPDF
        $pdf = new Dompdf();
        $pdf->loadHtml(view('admin.laporan.pdf', compact(
            'laporan',
            'totalPenerimaan',
            'totalPengeluaran',
            'overallTotal',
            'tanggalMulai',
            'tanggalAkhir',
            'kategoriId',
            'kategoriList',
            'cabang' // Pass cabang to the PDF view
        ))->render());

        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        // Output the generated PDF to the browser
        return $pdf->stream('laporan.pdf');
    }
}
