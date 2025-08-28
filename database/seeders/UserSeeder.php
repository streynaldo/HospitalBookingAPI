<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'nama' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'dob' => '1990-01-01',
            'no_telp' => '082143567890',
            'jenis_kelamin' => 'Laki-laki',
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'nama' => 'Jesse Pinkman',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'dob' => '1995-05-15',
            'no_telp' => '081234567890',
            'jenis_kelamin' => 'Laki-laki',
        ]);

        $user->assignRole('pasien');

        $user2 = User::create([
            'nama' => 'Stefanus Reynaldo',
            'email' => 'test2@example.com',
            'password' => bcrypt('password'),
            'dob' => '1995-05-15',
            'no_telp' => '081234567890',
            'jenis_kelamin' => 'Laki-laki',
        ]);

        $user2->assignRole('pasien');
    }
}
