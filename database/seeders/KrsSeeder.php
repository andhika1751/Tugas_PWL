<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KrsSeeder extends Seeder
{
    public function run(): void
    {
        $krs = [
            ['npm' => '2210101001', 'kode_matakuliah' => 'MK001001'],
            ['npm' => '2210101001', 'kode_matakuliah' => 'MK001002'],
            ['npm' => '2210101001', 'kode_matakuliah' => 'MK001003'],
            ['npm' => '2210101002', 'kode_matakuliah' => 'MK001001'],
            ['npm' => '2210101002', 'kode_matakuliah' => 'MK001004'],
            ['npm' => '2210101003', 'kode_matakuliah' => 'MK001002'],
            ['npm' => '2210101003', 'kode_matakuliah' => 'MK001005'],
            ['npm' => '2210101004', 'kode_matakuliah' => 'MK001003'],
            ['npm' => '2210101004', 'kode_matakuliah' => 'MK001006'],
            ['npm' => '2210101005', 'kode_matakuliah' => 'MK001001'],
            ['npm' => '2210101005', 'kode_matakuliah' => 'MK001005'],
            ['npm' => '2210101006', 'kode_matakuliah' => 'MK001002'],
            ['npm' => '2210101006', 'kode_matakuliah' => 'MK001006'],
            ['npm' => '2210101007', 'kode_matakuliah' => 'MK001003'],
            ['npm' => '2210101007', 'kode_matakuliah' => 'MK001004'],
            ['npm' => '2210101008', 'kode_matakuliah' => 'MK001001'],
            ['npm' => '2210101008', 'kode_matakuliah' => 'MK001006'],
            ['npm' => '2210101009', 'kode_matakuliah' => 'MK001002'],
            ['npm' => '2210101009', 'kode_matakuliah' => 'MK001003'],
            ['npm' => '2210101010', 'kode_matakuliah' => 'MK001004'],
        ];

        foreach ($krs as $k) {
            DB::table('krs')->insert([
                'npm'             => $k['npm'],
                'kode_matakuliah' => $k['kode_matakuliah'],
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}