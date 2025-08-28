<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '12:00:00',
                'hari' => 'Senin',
                'dokter_id' => 1,
            ],
            [
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '16:00:00',
                'hari' => 'Selasa',
                'dokter_id' => 1,
            ],
            [
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '12:00:00',
                'hari' => 'Rabu',
                'dokter_id' => 1,
            ],
            [
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '16:00:00',
                'hari' => 'Selasa',
                'dokter_id' => 2
            ],
            [
                'jam_mulai' => '09:00:00',
                'jam_selesai' => '12:00:00',
                'hari' => 'Rabu',
                'dokter_id' => 2,
            ],
            [
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '16:00:00',
                'hari' => 'Rabu',
                'dokter_id' => 3,
            ]
        ];

        foreach ($data as $item) {
            Jadwal::create($item);
        }
    }
}
