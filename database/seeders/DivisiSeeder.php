<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisiSeeder extends Seeder
{
    public function run(): void
    {
        $kepalaLldiktiId = DB::table('roles')->where('name', 'Kepala LLDIKTI')->value('id');
        $kbuId = DB::table('roles')->where('name', 'KBU')->value('id');

        $divisis = [
            ['nama' => 'Kelembagaan', 'parent_role_id' => $kepalaLldiktiId],
            ['nama' => 'Sistem Informasi', 'parent_role_id' => $kepalaLldiktiId],
            ['nama' => 'Sumber Daya', 'parent_role_id' => $kepalaLldiktiId],
            ['nama' => 'Belmawa', 'parent_role_id' => $kepalaLldiktiId],
            ['nama' => 'Riset dan Pengembangan', 'parent_role_id' => $kepalaLldiktiId],
            ['nama' => 'Perencanaan & Keuangan', 'parent_role_id' => $kbuId],
            ['nama' => 'Kepegawaian', 'parent_role_id' => $kbuId],
            ['nama' => 'Tata Usaha', 'parent_role_id' => $kbuId],
            ['nama' => 'Humas', 'parent_role_id' => $kbuId],
        ];

        foreach ($divisis as $divisi) {
            DB::table('divisis')->updateOrInsert(
                ['nama_divisi' => $divisi['nama']],
                [
                    'parent_role_id' => $divisi['parent_role_id'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
