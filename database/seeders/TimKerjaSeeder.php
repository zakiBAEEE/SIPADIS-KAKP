<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimKerjaSeeder extends Seeder
{
    public function run(): void
    {

        $timKerjas = [
            ['nama' => 'Kelembagaan'],
            ['nama' => 'Sistem Informasi'],
            ['nama' => 'Sumber Daya'],
            ['nama' => 'Belmawa'],
            ['nama' => 'Riset dan Pengembangan'],
            ['nama' => 'Perencanaan & Keuangan'],
            ['nama' => 'Kepegawaian'],
            ['nama' => 'Tata Usaha'],
            ['nama' => 'Humas'],
        ];

        foreach ($timKerjas as $timKerja) {
            DB::table('tim_kerjas')->updateOrInsert(
                ['nama_timKerja' => $timKerja['nama']],
                [
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
