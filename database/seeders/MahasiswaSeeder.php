<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswa = [
            ['npm' => '2210101001', 'nidn' => '0101197001', 'nama' => 'Agus Prasetyo'],
            ['npm' => '2210101002', 'nidn' => '0101197001', 'nama' => 'Rina Wulandari'],
            ['npm' => '2210101003', 'nidn' => '0215196802', 'nama' => 'Hendra Kurniawan'],
            ['npm' => '2210101004', 'nidn' => '0215196802', 'nama' => 'Fitri Handayani'],
            ['npm' => '2210101005', 'nidn' => '0308197503', 'nama' => 'Bambang Sugiarto'],
            ['npm' => '2210101006', 'nidn' => '0308197503', 'nama' => 'Yuni Astuti'],
            ['npm' => '2210101007', 'nidn' => '0422198004', 'nama' => 'Doni Setiawan'],
            ['npm' => '2210101008', 'nidn' => '0422198004', 'nama' => 'Maya Sari'],
            ['npm' => '2210101009', 'nidn' => '0510197205', 'nama' => 'Rizky Firmansyah'],
            ['npm' => '2210101010', 'nidn' => '0510197205', 'nama' => 'Novi Andriani'],
        ];

        foreach ($mahasiswa as $m) {
            DB::table('mahasiswa')->insert([
                'npm'        => $m['npm'],
                'nidn'       => $m['nidn'],
                'nama'       => $m['nama'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}