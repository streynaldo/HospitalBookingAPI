<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriProfesional;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriProfesionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Riwayat Pendidikan'],
            ['nama' => 'Pengalaman Praktik'],
            ['nama' => 'Prestasi & Penghargaan'],
        ];

        foreach ($data as $item) {
            KategoriProfesional::create($item);
        }
    }
}
