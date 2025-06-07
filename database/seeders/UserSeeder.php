<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Divisi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua role dan divisi
        $roleMap = Role::pluck('id', 'name'); // ['Kepala LLDIKTI' => 1, ...]
        $divisiList = Divisi::pluck('id', 'nama_divisi'); // ['Kelembagaan' => 1, ...]

        // ===================== //
        // Users tanpa divisi
        // ===================== //
        $nonDivisionalUsers = [
            ['name' => 'Irwan Hidayat', 'username' => 'kepala01', 'role' => 'Kepala LLDIKTI', 'password' => 'password'],
            ['name' => 'Mira Lestari', 'username' => 'kbu01', 'role' => 'KBU', 'password' => 'password'],
            ['name' => 'Dimas Prakoso', 'username' => 'adminsurat01', 'role' => 'Admin Surat', 'password' => 'password'],
            ['name' => 'Anisa Wulandari', 'username' => 'superadmin01', 'role' => 'Super Admin Surat', 'password' => 'password'],
        ];

        foreach ($nonDivisionalUsers as $user) {
            User::updateOrCreate(
                ['username' => $user['username']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make($user['password']),
                    'role_id' => $roleMap[$user['role']],
                    'divisi_id' => null,
                ]
            );
        }

        // ===================== //
        // Users dengan divisi
        // ===================== //
        foreach ($divisiList as $divisiName => $divisiId) {
            // Tambah satu Katimja per divisi
            User::updateOrCreate(
                ['username' => 'katimja_' . strtolower(str_replace(' ', '_', $divisiName))],
                [
                    'name' => fake()->name(), // Nama sungguhan random
                    'password' => Hash::make('password'),
                    'role_id' => $roleMap['Katimja'],
                    'divisi_id' => $divisiId,
                ]
            );

            // Tambah satu Staff per divisi
            User::updateOrCreate(
                ['username' => 'staff_' . strtolower(str_replace(' ', '_', $divisiName))],
                [
                    'name' => fake()->name(), // Nama sungguhan random
                    'password' => Hash::make('password'),
                    'role_id' => $roleMap['Staff'],
                    'divisi_id' => $divisiId,
                ]
            );
        }
    }
}
