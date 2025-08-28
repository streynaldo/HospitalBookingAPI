<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Dokter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Dr. John Doe',
                'spesialis' => 'Ortopedi Tangan',
                'gambar' => 'doctor1.jpg',
                'klinik_id' => 1
            ],
            [
                'nama' => 'Dr. Steven Doe',
                'spesialis' => 'Ortopedi Kaki',
                'gambar' => 'doctor1.jpg',
                'klinik_id' => 1
            ],
            [
                'nama' => 'Dr. Michael Doe',
                'spesialis' => 'Ortopedi Kepala',
                'gambar' => 'doctor1.jpg',
                'klinik_id' => 1
            ],
            [
                'nama' => 'Dr. Jane Smith',
                'spesialis' => 'Dermatologist',
                'gambar' => 'doctor2.jpg',
                'klinik_id' => 5
            ],
            [
                'nama' => 'Dr. Emily Johnson',
                'spesialis' => 'Pediatrician',
                'gambar' => 'doctor3.jpg',
                'klinik_id' => 4
            ]
        ];

        foreach ($data as $d){
            Dokter::create($d);
        }
    }
}
