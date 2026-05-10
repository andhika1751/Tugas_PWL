<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    public function run(): void
    {
        $dosen = [
            ['nidn' => '0101197001', 'nama' => 'Dr. Budi Santoso, M.Kom'],
            ['nidn' => '0215196802', 'nama' => 'Prof. Siti Rahayu, Ph.D'],
            ['nidn' => '0308197503', 'nama' => 'Drs. Ahmad Fauzi, M.T'],
            ['nidn' => '0422198004', 'nama' => 'Ir. Dewi Lestari, M.M'],
            ['nidn' => '0510197205', 'nama' => 'Dr. Rudi Hermawan, S.T'],
        ];

        foreach ($dosen as $d) {
            DB::table('dosen')->insert([
                'nidn'       => $d['nidn'],
                'nama'       => $d['nama'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}