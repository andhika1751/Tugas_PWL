<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatakuliahSeeder extends Seeder
{
    public function run(): void
    {
        $matakuliah = [
            ['kode_matakuliah' => 'MK001001', 'nama_matakuliah' => 'Pemrograman Web',             'sks' => 3],
            ['kode_matakuliah' => 'MK001002', 'nama_matakuliah' => 'Basis Data',                   'sks' => 3],
            ['kode_matakuliah' => 'MK001003', 'nama_matakuliah' => 'Struktur Data dan Algoritma',  'sks' => 4],
            ['kode_matakuliah' => 'MK001004', 'nama_matakuliah' => 'Jaringan Komputer',            'sks' => 3],
            ['kode_matakuliah' => 'MK001005', 'nama_matakuliah' => 'Kecerdasan Buatan',            'sks' => 3],
            ['kode_matakuliah' => 'MK001006', 'nama_matakuliah' => 'Rekayasa Perangkat Lunak',     'sks' => 4],
        ];

        foreach ($matakuliah as $mk) {
            DB::table('matakuliah')->insert([
                'kode_matakuliah'  => $mk['kode_matakuliah'],
                'nama_matakuliah'  => $mk['nama_matakuliah'],
                'sks'              => $mk['sks'],
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }
}