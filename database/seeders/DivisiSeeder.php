<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisiSeeder extends Seeder
{
    public function run(): void
    {
        $divisis = [
            'Kelembagaan',
            'Sistem Informasi',
            'Sumber Daya',
            'Belmawa',
            'Riset dan Pengembangan',
            'Perencanaan & Keuangan',
            'Kepegawaian',
            'Tata Usaha',
            'Humas',
        ];

        foreach ($divisis as $divisi) {
            DB::table('divisis')->updateOrInsert(
                ['nama_divisi' => $divisi],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
