<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan penting! Tabel dengan foreign key harus di-seed setelah tabel induknya
        $this->call([
            DosenSeeder::class,
            MahasiswaSeeder::class,
            MatakuliahSeeder::class,
            JadwalSeeder::class,
            KrsSeeder::class,
        ]);
    }
}