<?php

namespace Database\Seeders;

use App\Models\Cuti;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CutiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'dokter_id' => 1,
                'tanggal_mulai' => '2025-07-01',
                'tanggal_selesai' => '2025-07-05',
            ],
            [
                'dokter_id' => 2,
                'tanggal_mulai' => '2025-08-10',
                'tanggal_selesai' => '2025-08-12',
            ],
            [
                'dokter_id' => 3,
                'tanggal_mulai' => '2025-09-15',
                'tanggal_selesai' => '2025-09-20',
            ],
            [
                'dokter_id' => 4,
                'tanggal_mulai' => '2025-10-01',
                'tanggal_selesai' => '2025-10-05',
            ],
        ];
        foreach ($data as $item) {
            Cuti::create($item);
        }
    }
}
