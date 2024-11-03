<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengeluaranTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('pengeluaran')->insert([
            [
                'id_pengeluaran' => 'PU0001',
                'id_user' => 'A0001', // contoh id_user
                'id_kategori' => 'K0001', // contoh id_kategori
                'bukti' => 'BUKTI003',
                'tanggal' => now(),
                'keterangan' => 'Pembelian alat tulis',
                'nominal' => 200000,
            ],
            [
                'id_pengeluaran' => 'PU0002',
                'id_user' => 'A0002',
                'id_kategori' => 'K0002',
                'bukti' => 'BUKTI004',
                'tanggal' => now(),
                'keterangan' => 'Pembayaran listrik',
                'nominal' => 300000,
            ],
            // Tambahkan data lainnya sesuai kebutuhan
        ]);
    }
}
