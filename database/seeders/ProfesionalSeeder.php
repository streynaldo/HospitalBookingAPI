<?php

namespace Database\Seeders;

use App\Models\Profesional;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProfesionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'deskripsi' => 'Fakultas Kedokteran Universitas Indonesia',
                'tahun' => 2005,
                'kategori_profesional_id' => 1,
                'dokter_id' => 1,
            ],
            [
                'deskripsi' => 'Spesialis Penyakit Dalam di RS Cipto Mangunkusumo',
                'tahun' => 2010,
                'kategori_profesional_id' => 2,
                'dokter_id' => 1,
            ],
            [
                'deskripsi' => 'Penghargaan Dokter Terbaik dari Ikatan Dokter Indonesia',
                'tahun' => 2018,
                'kategori_profesional_id' => 3,
                'dokter_id' => 1,
            ],
            [
                'deskripsi' => 'Spesialis Bedah Umum di RS Cipto Mangunkusumo',
                'tahun' => 2015,
                'kategori_profesional_id' => 1,
                'dokter_id' => 2,
            ]
        ];

        foreach ($data as $item) {
            Profesional::create($item);
        }
    }
}
