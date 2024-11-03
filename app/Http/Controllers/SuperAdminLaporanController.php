<?php

namespace App\Http\Controllers;

use App\Models\Penerimaan;
use App\Models\Pengeluaran;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dompdf\Dompdf;

class SuperAdminLaporanController extends Controller
{
    public function laporan(Request $request)
    {
        $user = auth()->user();

        // Fetch filter parameters from the request
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $cabangId = $request->input('cabang_id');
        $kategoriId = $request->input('kategori_id');

        // Get lists of cabang and kategori for filter options
        $cabangList = User::select('cabang')->distinct()->get();
        $kategoriList = Kategori::all();

        $laporan = collect();

        // Include penerimaan data only when no kategori is selected
        if (empty($kategoriId)) {
            $penerimaanQuery = Penerimaan::with('user');

            if ($cabangId) {
                $penerimaanQuery->whereHas('user', function ($query) use ($cabangId) {
                    $query->where('cabang', $cabangId);
                });
            }

            if ($tanggalMulai && $tanggalAkhir) {
                $penerimaanQuery->whereBetween('tanggal', [Carbon::parse($tanggalMulai), Carbon::parse($tanggalAkhir)]);
            }

            $penerimaanData = $penerimaanQuery->get();

            $laporan = $laporan->merge(
                $penerimaanData->map(function ($data) {
                    return (object) [
                        'tanggal' => $data->tanggal,
                        'kategori' => '-',
                        'penerimaan' => $data->nominal,
                        'pengeluaran' => null,
                        'keterangan' => $data->keterangan,
                        'cabang' => $data->user->cabang,
                    ];
                })
            );
        }

        // Filter pengeluaran data based on selected filters, including kategori filter
        $pengeluaranQuery = Pengeluaran::with('kategori', 'user');

        if ($cabangId) {
            $pengeluaranQuery->whereHas('user', function ($query) use ($cabangId) {
                $query->where('cabang', $cabangId);
            });
        }

        if ($tanggalMulai && $tanggalAkhir) {
            $pengeluaranQuery->whereBetween('tanggal', [Carbon::parse($tanggalMulai), Carbon::parse($tanggalAkhir)]);
        }

        if ($kategoriId) {
            $pengeluaranQuery->where('id_kategori', $kategoriId);
        }

        $pengeluaranData = $pengeluaranQuery->get();

        $laporan = $laporan->merge(
            $pengeluaranData->map(function ($data) {
                return (object) [
                    'tanggal' => $data->tanggal,
                    'kategori' => optional($data->kategori)->nama_kategori ?? '-',
                    'penerimaan' => null,
                    'pengeluaran' => $data->nominal,
                    'keterangan' => $data->keterangan,
                    'cabang' => $data->user->cabang,
                ];
            })
        )->sortBy('tanggal');

        // Calculate totals
        $totalPenerimaan = $laporan->whereNotNull('penerimaan')->sum('penerimaan');
        $totalPengeluaran = $laporan->whereNotNull('pengeluaran')->sum('pengeluaran');
        $netTotal = $totalPenerimaan - $totalPengeluaran;

        // Pass data to view
        return view('superadmin.laporan.index', compact(
            'cabangList',
            'kategoriList',
            'laporan',
            'totalPenerimaan',
            'totalPengeluaran',
            'netTotal',
            'tanggalMulai',
            'tanggalAkhir',
            'cabangId',
            'kategoriId'
        ));
    }

    public function downloadPDF(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $cabangId = $request->input('cabang_id');
        $kategoriId = $request->input('kategori_id');

        // Fetch the selected category name
        $selectedKategori = Kategori::find($kategoriId);
        $kategoriName = $selectedKategori ? $selectedKategori->nama_kategori : 'Semua Kategori';

        // Fetch the reports with the existing filters
        $laporan = collect();

        if (empty($kategoriId)) {
            $penerimaanQuery = Penerimaan::with('user');

            if ($cabangId) {
                $penerimaanQuery->whereHas('user', function ($query) use ($cabangId) {
                    $query->where('cabang', $cabangId);
                });
            }

            if ($tanggalMulai && $tanggalAkhir) {
                $penerimaanQuery->whereBetween('tanggal', [Carbon::parse($tanggalMulai), Carbon::parse($tanggalAkhir)]);
            }

            $penerimaanData = $penerimaanQuery->get();

            $laporan = $laporan->merge(
                $penerimaanData->map(function ($data) {
                    return (object) [
                        'tanggal' => $data->tanggal,
                        'kategori' => '-',
                        'penerimaan' => $data->nominal,
                        'pengeluaran' => null,
                        'keterangan' => $data->keterangan,
                        'cabang' => $data->user->cabang,
                    ];
                })
            );
        }

        $pengeluaranQuery = Pengeluaran::with('kategori', 'user');

        if ($cabangId) {
            $pengeluaranQuery->whereHas('user', function ($query) use ($cabangId) {
                $query->where('cabang', $cabangId);
            });
        }

        if ($tanggalMulai && $tanggalAkhir) {
            $pengeluaranQuery->whereBetween('tanggal', [Carbon::parse($tanggalMulai), Carbon::parse($tanggalAkhir)]);
        }

        if ($kategoriId) {
            $pengeluaranQuery->where('id_kategori', $kategoriId);
        }

        $pengeluaranData = $pengeluaranQuery->get();

        $laporan = $laporan->merge(
            $pengeluaranData->map(function ($data) {
                return (object) [
                    'tanggal' => $data->tanggal,
                    'kategori' => optional($data->kategori)->nama_kategori ?? '-',
                    'penerimaan' => null,
                    'pengeluaran' => $data->nominal,
                    'keterangan' => $data->keterangan,
                    'cabang' => $data->user->cabang,
                ];
            })
        )->sortBy('tanggal');

        $totalPenerimaan = $laporan->whereNotNull('penerimaan')->sum('penerimaan');
        $totalPengeluaran = $laporan->whereNotNull('pengeluaran')->sum('pengeluaran');
        $netTotal = $totalPenerimaan - $totalPengeluaran;

        $pdf = new Dompdf();
        $pdf->loadHtml(view('superadmin.laporan.pdf', compact(
            'laporan',
            'totalPenerimaan',
            'totalPengeluaran',
            'netTotal',
            'tanggalMulai',
            'tanggalAkhir',
            'cabangId',
            'kategoriName'
        ))->render());

        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        return $pdf->stream('laporan.pdf');
    }
}
