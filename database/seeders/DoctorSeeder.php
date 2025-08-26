<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Dr. John Smith',
                'specialty' => 'Cardiology',
            ],
            [
                'name' => 'Dr. Jane Doe',
                'specialty' => 'Neurology',
            ],
            [
                'name' => 'Dr. Emily Johnson',
                'specialty' => 'Pediatrics',
            ],
        ];

        foreach ($data as $d){
            Doctor::create($d);
        }
    }
}
