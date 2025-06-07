<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SuratMasuk;

class SuratMasukSeeder extends Seeder
{
    public function run(): void
    {
        SuratMasuk::insert([
            [
                'nomor_agenda' => '0346/TU/2025',
                'nomor_surat' => 'UMDP/2025/139',
                'pengirim' => 'Universitas Multi Data Palembang',
                'tanggal_surat' => '2025-02-25',
                'tanggal_terima' => '2025-03-01',
                'perihal' => 'Permohonan Beasiswa',
                'klasifikasi_surat' => 'Umum',
                'sifat' => 'Rahasia',
                'file_path' => 'LogHarianMoza_21Maret2025 (1).pdf',
                'status' => 'draft',
            ],
            [
                'nomor_agenda' => '0347/TU/2025',
                'nomor_surat' => 'UNSRI/2025/140',
                'pengirim' => 'Universitas Sriwijaya',
                'tanggal_surat' => '2025-02-26',
                'tanggal_terima' => '2025-03-02',
                'perihal' => 'Undangan Seminar',
                'klasifikasi_surat' => 'Pengaduan',
                'sifat' => 'Penting',
                'file_path' => null,
                'status' => 'diverifikasi',
            ],
            [
                'nomor_agenda' => '0348/TU/2025',
                'nomor_surat' => 'POLSRI/2025/141',
                'pengirim' => 'Politeknik Negeri Sriwijaya',
                'tanggal_surat' => '2025-02-27',
                'tanggal_terima' => '2025-03-03',
                'perihal' => 'Permintaan Data Alumni',
                'klasifikasi_surat' => 'Permintaan Informasi',
                'sifat' => 'Segera',
                'file_path' => null,
                'status' => 'diproses',
            ],
        ]);
    }
}
