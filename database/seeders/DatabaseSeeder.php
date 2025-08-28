<?php

namespace Database\Seeders;

use App\Models\Klinik;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\DoctorSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            PasienSeeder::class,
            KlinikSeeder::class,
            DokterSeeder::class,
            JadwalSeeder::class,
            SlotSeeder::class,
            KategoriProfesionalSeeder::class,
            ProfesionalSeeder::class,
            CutiSeeder::class,
        ]);
    }
}
