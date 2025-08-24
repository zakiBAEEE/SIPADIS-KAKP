<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\TimKerja;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua role dan Tim Kerja
        $roleMap = Role::pluck('id', 'name'); // ['Kepala LLDIKTI' => 1, ...]
        $timKerjaList = TimKerja::pluck('id', 'nama_timKerja'); 

        // ===================== //
        // Users tanpa Tim Kerja
        // ===================== //
        $nonTimKerjaUsers = [
            ['name' => 'Ishak Iskandar', 'username' => 'kepala01', 'role' => 'Kepala LLDIKTI', 'password' => 'password'],
            ['name' => 'Fansyuri Dwi Putra', 'username' => 'kbu01', 'role' => 'KBU', 'password' => 'password'],
            ['name' => 'Dimas Prakoso', 'username' => 'adminsurat01', 'role' => 'Admin', 'password' => 'password'],
        ];

        foreach ($nonTimKerjaUsers as $user) {
            User::updateOrCreate(
                ['username' => $user['username']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make($user['password']),
                    'role_id' => $roleMap[$user['role']],
                    'tim_kerja_id' => null,
                ]
            );
        }

        // ===================== //
        // Users dengan Tim Kerja
        // ===================== //
        foreach ($timKerjaList as $timKerjaName => $timKerjaId) {
            // Tambah satu Katimja per Tim Kerja
            User::updateOrCreate(
                ['username' => 'katimja_' . strtolower(str_replace(' ', '_', $timKerjaName))],
                [
                    'name' => fake()->name(), // Nama sungguhan random
                    'password' => Hash::make('password'),
                    'role_id' => $roleMap['Katimja'],
                    'tim_kerja_id' => $timKerjaId,
                ]
            );

            // Tambah satu Staff per Tim Kerja
            User::updateOrCreate(
                ['username' => 'staff_' . strtolower(str_replace(' ', '_', $timKerjaName))],
                [
                    'name' => fake()->name(), // Nama sungguhan random
                    'password' => Hash::make('password'),
                    'role_id' => $roleMap['Staf'],
                    'tim_kerja_id' => $timKerjaId,
                ]
            );
        }
    }
}
