<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $jadwal = [
            [
                'kode_matakuliah' => 'MK001001',
                'nidn'            => '0101197001',
                'kelas'           => 'A',
                'hari'            => 'Senin',
                'jam'             => '2024-01-01 08:00:00',
            ],
            [
                'kode_matakuliah' => 'MK001001',
                'nidn'            => '0101197001',
                'kelas'           => 'B',
                'hari'            => 'Selasa',
                'jam'             => '2024-01-02 10:00:00',
            ],
            [
                'kode_matakuliah' => 'MK001002',
                'nidn'            => '0215196802',
                'kelas'           => 'A',
                'hari'            => 'Rabu',
                'jam'             => '2024-01-03 08:00:00',
            ],
            [
                'kode_matakuliah' => 'MK001003',
                'nidn'            => '0308197503',
                'kelas'           => 'A',
                'hari'            => 'Kamis',
                'jam'             => '2024-01-04 13:00:00',
            ],
            [
                'kode_matakuliah' => 'MK001004',
                'nidn'            => '0422198004',
                'kelas'           => 'B',
                'hari'            => 'Jumat',
                'jam'             => '2024-01-05 10:00:00',
            ],
            [
                'kode_matakuliah' => 'MK001005',
                'nidn'            => '0510197205',
                'kelas'           => 'A',
                'hari'            => 'Senin',
                'jam'             => '2024-01-01 13:00:00',
            ],
            [
                'kode_matakuliah' => 'MK001006',
                'nidn'            => '0215196802',
                'kelas'           => 'B',
                'hari'            => 'Rabu',
                'jam'             => '2024-01-03 13:00:00',
            ],
        ];

        foreach ($jadwal as $j) {
            DB::table('jadwal')->insert([
                'kode_matakuliah' => $j['kode_matakuliah'],
                'nidn'            => $j['nidn'],
                'kelas'           => $j['kelas'],
                'hari'            => $j['hari'],
                'jam'             => $j['jam'],
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}