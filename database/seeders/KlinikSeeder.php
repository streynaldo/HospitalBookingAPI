<?php

namespace Database\Seeders;

use App\Models\Klinik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KlinikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Dokter Umum', 'deskripsi' => 'Pelayanan kesehatan umum'],
            ['nama' => 'Anak', 'deskripsi' => 'Pelayanan kesehatan anak'],
            ['nama' => 'Andrologi', 'deskripsi' => 'Pelayanan kesehatan pria'],
            ['nama' => 'Bedah Anak', 'deskripsi' => 'Pelayanan bedah untuk anak'],
            ['nama' => 'Bedah Digestif', 'deskripsi' => 'Pelayanan bedah saluran cerna'],
            ['nama' => 'Bedah Onkologi', 'deskripsi' => 'Pelayanan bedah kanker'],
            ['nama' => 'Bedah Orthopedi & Traumatologi', 'deskripsi' => 'Pelayanan bedah tulang dan sendi'],
            ['nama' => 'Bedah Plastik', 'deskripsi' => 'Pelayanan bedah estetika'],
            ['nama' => 'Bedah Saraf', 'deskripsi' => 'Pelayanan bedah saraf'],
            ['nama' => 'Bedah Thoraks & Kardiovaskular', 'deskripsi' => 'Pelayanan bedah jantung dan pembuluh darah'],
            ['nama' => 'Bedah Umum', 'deskripsi' => 'Pelayanan bedah umum'],
            ['nama' => 'Bedah Urologi', 'deskripsi' => 'Pelayanan bedah saluran kemih'],
            ['nama' => 'FNAB', 'deskripsi' => 'Pelayanan biopsi jarum halus'],
            ['nama' => 'Gigi & Kesehatan Mulut', 'deskripsi' => 'Pelayanan kesehatan gigi dan mulut'],
            ['nama' => 'Jantung & Pembuluh Darah', 'deskripsi' => 'Pelayanan kesehatan jantung'],
            ['nama' => 'Jiwa', 'deskripsi' => 'Pelayanan kesehatan mental'],
            ['nama' => 'Kulit & Kelamin', 'deskripsi' => 'Pelayanan kesehatan kulit dan kelamin'],
            ['nama' => 'Mata', 'deskripsi' => 'Pelayanan kesehatan mata'],
            ['nama' => 'Nyeri', 'deskripsi' => 'Pelayanan untuk mengatasi nyeri'],
            ['nama' => 'Obstetri & Ginekologi', 'deskripsi' => 'Pelayanan kesehatan wanita dan kehamilan'],
            ['nama' => 'Onkologi Radiasi', 'deskripsi' => 'Pelayanan terapi radiasi untuk kanker'],
            ['nama' => 'Paru', 'deskripsi' => 'Pelayanan kesehatan paru-paru'],
            ['nama' => 'Penyakit Dalam', 'deskripsi' => 'Pelayanan kesehatan penyakit dalam'],
            ['nama' => 'Radiologi', 'deskripsi' => 'Pelayanan pemeriksaan radiologi'],
            ['nama' => 'Rehabilitasi Medik', 'deskripsi' => 'Pelayanan rehabilitasi medis'],
            ['nama' => 'Saraf', 'deskripsi' => 'Pelayanan kesehatan saraf'],
            ['nama' => 'THT-KL', 'deskripsi' => 'Pelayanan kesehatan telinga, hidung, dan tenggorokan'],
            ['nama' => 'Laboratorium', 'deskripsi' => 'Pelayanan pemeriksaan laboratorium'],
        ];

        foreach ($data as $item) {
            Klinik::create($item);
        }
    }
}
