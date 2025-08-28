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
            ['nama' => 'Ortopedi & Traumatology', 'deskripsi' => 'Specialized in bone and joint disorders', 'icon' => 'ortopediicon.png', 'gambar' => 'ortopedi.jpg'],
            ['nama' => 'Cardiology', 'deskripsi' => 'Specialized in heart conditions', 'icon' => 'cardiologyicon.png', 'gambar' => 'cardiology.jpg'],
            ['nama' => 'Neurology', 'deskripsi' => 'Specialized in nervous system disorders', 'icon' => 'neurologyicon.png', 'gambar' => 'neurology.jpg'],
            ['nama' => 'Pediatrics', 'deskripsi' => 'Specialized in child health', 'icon' => 'pediatricsicon.png', 'gambar' => 'pediatrics.jpg'],
            ['nama' => 'Dermatology', 'deskripsi' => 'Specialized in skin conditions', 'icon' => 'dermatologyicon.png', 'gambar' => 'dermatology.jpg'],
            ['nama' => 'Psychiatry', 'deskripsi' => 'Specialized in mental health', 'icon' => 'psychiatryicon.png', 'gambar' => 'psychiatry.jpg'],
            ['nama' => 'Ophthalmology', 'deskripsi' => 'Specialized in eye care', 'icon' => 'ophthalmologyicon.png', 'gambar' => 'ophthalmology.jpg'],
            ['nama' => 'ENT (Ear, Nose, Throat)', 'deskripsi' => 'Specialized in ear, nose, and throat disorders', 'icon' => 'enticon.png', 'gambar' => 'ent.jpg'],
            ['nama' => 'Gynecology & Obstetrics', 'deskripsi' => 'Specialized in women\'s health and childbirth', 'icon' => 'gynecologyicon.png', 'gambar' => 'gynecology.jpg'],
            ['nama' => 'General Surgery', 'deskripsi' => 'Specialized in surgical procedures', 'icon' => 'surgeryicon.png', 'gambar' => 'surgery.jpg'],
        ];

        foreach ($data as $item) {
            Klinik::create($item);
        }
    }
}
