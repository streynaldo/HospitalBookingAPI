<?php

namespace Database\Seeders;

use App\Models\Pasien;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'John Doe', 'dob' => '1990-01-01','jenis_kelamin' => 'Laki-laki', 'user_id' => 2],
            ['nama' => 'Jane Smith', 'dob' => '1985-05-15', 'jenis_kelamin' => 'Perempuan', 'user_id' => 2],
            ['nama' => 'Alice Johnson', 'dob' => '1992-07-20', 'jenis_kelamin' => 'Perempuan', 'user_id' => 2],
            ['nama' => 'Bob Brown', 'dob' => '1988-03-30', 'jenis_kelamin' => 'Laki-laki', 'user_id' => 2],
            ['nama' => 'Charlie Davis', 'dob' => '1995-12-10', 'jenis_kelamin' => 'Laki-laki', 'user_id' => 2],
            ['nama' => 'Steven Davis', 'dob' => '1995-12-10', 'jenis_kelamin' => 'Laki-laki', 'user_id' => 3],
            ['nama' => 'Emily Clark', 'dob' => '1993-04-12', 'jenis_kelamin' => 'Perempuan', 'user_id' => 3],
        ];

        foreach ($data as $item) {
            Pasien::create($item);
        }
    }
}
