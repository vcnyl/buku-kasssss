<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'id_user' => 'SA0001',
                'username' => 'vincen@gmail.com',
                'password' => Hash::make('12345678'),
                'nama' => 'vincen',
                'role' => 'superadmin',
                'cabang' => 'kaliwates',
                'alamat' => 'Jl. Admin 1',
                'no_hp' => '081234567890',
                'foto' => null,
            ],
            [
                'id_user' => 'A0001',
                'username' => 'fauzan@gmail.com',
                'password' => Hash::make('12345678'),
                'nama' => 'fauzan',
                'role' => 'admin',
                'cabang' => 'tegalbesar',
                'alamat' => 'Jl. Admin 2',
                'no_hp' => '081234567891',
                'foto' => null,
            ],
            [
                'id_user' => 'A0002',
                'username' => 'mega@gmail.com',
                'password' => Hash::make('12345678'),
                'nama' => 'mega',
                'role' => 'admin',
                'cabang' => 'kaliwates',
                'alamat' => 'Jl. Admin 3',
                'no_hp' => '081234567891',
                'foto' => null,
            ],
        ]);
    }
}

