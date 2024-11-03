<?php

namespace Database\Seeders;

// database/seeders/KategoriSeeder.php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('kategori')->insert([
            ['id_kategori' => 'K0001', 'nama_kategori' => 'ATK'],
            ['id_kategori' => 'K0002', 'nama_kategori' => 'TRANSPORTASI'],
            ['id_kategori' => 'K0003', 'nama_kategori' => 'KONSUMSI'],
            ['id_kategori' => 'K0004', 'nama_kategori' => 'LAIN LAIN'],
            // Tambahkan kategori lain sesuai kebutuhan
        ]);
    }
}

