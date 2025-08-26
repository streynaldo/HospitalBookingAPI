<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // permissions granular
        $perms = [
            'doctor.read',
            'doctor.create',
            'doctor.update',
        ];
        foreach ($perms as $p) Permission::firstOrCreate(['name' => $p]);

        $admin  = Role::firstOrCreate(['name' => 'admin']);
        $pasien = Role::firstOrCreate(['name' => 'pasien']);

        // admin boleh kelola dokter & lihat appointment terkini
        $admin->givePermissionTo([
            'doctor.read',
            'doctor.create',
            'doctor.update',
        ]);

        // pasien boleh booking & kelola miliknya
        $pasien->givePermissionTo([
            'doctor.read',
        ]);
    }
}
