<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenerimaanTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('penerimaan')->insert([
            [
                'id_penerimaan' => 'PA0001',
                'id_user' => 'A0001', // contoh id_user
                'bukti' => 'BUKTI001',
                'tanggal' => now(),
                'keterangan' => 'Penerimaan dari donatur A',
                'nominal' => 500000,
            ],
            [
                'id_penerimaan' => 'PA0002',
                'id_user' => 'A0002',
                'bukti' => 'BUKTI002',
                'tanggal' => now(),
                'keterangan' => 'Penerimaan dari donatur B',
                'nominal' => 1000000,
            ],
            // Tambahkan data lainnya sesuai kebutuhan
        ]);
    }
}
