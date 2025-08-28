<?php

namespace Database\Seeders;

use App\Models\Slot;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'slot_mulai' => '09:00:00',
                'slot_selesai' => '09:30:00',
                'jadwal_id' => 1,
            ],
            [
                'slot_mulai' => '09:30:00',
                'slot_selesai' => '10:00:00',
                'jadwal_id' => 1,
            ],
            [
                'slot_mulai' => '10:00:00',
                'slot_selesai' => '10:30:00',
                'jadwal_id' => 1,
            ],
            [
                'slot_mulai' => '10:30:00',
                'slot_selesai' => '11:00:00',
                'jadwal_id' => 1,
            ],
            [
                'slot_mulai' => '11:00:00',
                'slot_selesai' => '11:30:00',
                'jadwal_id' => 1,
            ],
            [
                'slot_mulai' => '11:30:00',
                'slot_selesai' => '12:00:00',
                'jadwal_id' => 1,
            ],
            [
                'slot_mulai' => '13:00:00',
                'slot_selesai' => '13:30:00',
                'jadwal_id' => 2,
            ],
            [
                'slot_mulai' => '13:30:00',
                'slot_selesai' => '14:00:00',
                'jadwal_id' => 2,
            ],
            [
                'slot_mulai' => '14:00:00',
                'slot_selesai' => '14:30:00',
                'jadwal_id' => 2,
            ],
            [
                'slot_mulai' => '14:30:00',
                'slot_selesai' => '15:00:00',
                'jadwal_id' => 2,
            ],
            [
                'slot_mulai' => '15:00:00',
                'slot_selesai' => '15:30:00',
                'jadwal_id' => 2,
            ],
            [
                'slot_mulai' => '15:30:00',
                'slot_selesai' => '16:00:00',
                'jadwal_id' => 2,
            ],
            [
                'slot_mulai' => '09:00:00',
                'slot_selesai' => '09:30:00',
                'jadwal_id' => 3,
            ],
            [
                'slot_mulai' => '09:30:00',
                'slot_selesai' => '10:00:00',
                'jadwal_id' => 3,
            ],
            [
                'slot_mulai' => '10:00:00',
                'slot_selesai' => '10:30:00',
                'jadwal_id' => 3,
            ],
            [
                'slot_mulai' => '10:30:00',
                'slot_selesai' => '11:00:00',
                'jadwal_id' => 3,
            ],
            [
                'slot_mulai' => '11:00:00',
                'slot_selesai' => '11:30:00',
                'jadwal_id' => 3,
            ],
            [
                'slot_mulai' => '11:30:00',
                'slot_selesai' => '12:00:00',
                'jadwal_id' => 3,
            ],
            [
                'slot_mulai' => '13:00:00',
                'slot_selesai' => '13:30:00',
                'jadwal_id' => 4,
            ],
            [
                'slot_mulai' => '13:30:00',
                'slot_selesai' => '14:00:00',
                'jadwal_id' => 4,
            ],
            [
                'slot_mulai' => '14:00:00',
                'slot_selesai' => '14:30:00',
                'jadwal_id' => 4,
            ],
            [
                'slot_mulai' => '14:30:00',
                'slot_selesai' => '15:00:00',
                'jadwal_id' => 4,
            ],
            [
                'slot_mulai' => '15:00:00',
                'slot_selesai' => '15:30:00',
                'jadwal_id' => 4,
            ],
            [
                'slot_mulai' => '15:30:00',
                'slot_selesai' => '16:00:00',
                'jadwal_id' => 4,
            ],
            [
                'slot_mulai' => '09:00:00',
                'slot_selesai'  => '09:30:00',
                'jadwal_id' => 5,
            ],
            [
                'slot_mulai' => '09:30:00',
                'slot_selesai' => '10:00:00',
                'jadwal_id' => 5,
            ],
            [
                'slot_mulai' => '10:00:00',
                'slot_selesai' => '10:30:00',
                'jadwal_id' => 5,
            ],
            [
                'slot_mulai' => '10:30:00',
                'slot_selesai' => '11:00:00',
                'jadwal_id' => 5,
            ],
            [
                'slot_mulai' => '11:00:00',
                'slot_selesai' => '11:30:00',
                'jadwal_id' => 5,
            ],
            [
                'slot_mulai' => '11:30:00',
                'slot_selesai' => '12:00:00',
                'jadwal_id' => 5,
            ],
            [
                'slot_mulai' => '13:00:00',
                'slot_selesai' => '13:30:00',
                'jadwal_id' => 6,
            ],
            [
                'slot_mulai' => '13:30:00',
                'slot_selesai' => '14:00:00',
                'jadwal_id' => 6,
            ],
            [
                'slot_mulai' => '14:00:00',
                'slot_selesai' => '14:30:00',
                'jadwal_id' => 6,
            ],
            [
                'slot_mulai' => '14:30:00',
                'slot_selesai' => '15:00:00',
                'jadwal_id' => 6,
            ],
            [
                'slot_mulai' => '15:00:00',
                'slot_selesai' => '15:30:00',
                'jadwal_id' => 6,
            ],
            [
                'slot_mulai' => '15:30:00',
                'slot_selesai' => '16:00:00',
                'jadwal_id' => 6,
            ],
        ];
        foreach ($data as $item) {
            Slot::create($item);
        }
    }
}
