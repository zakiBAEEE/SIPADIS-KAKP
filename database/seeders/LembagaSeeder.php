<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LembagaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lembaga')->insert([
            'nama_kementerian' => 'KEMENTERIAN PENDIDIKAN SAINS, DAN TEKNOLOGI',
            'nama_lembaga' => 'LEMBAGA LAYANAN PENDIDIKAN TINGGI WILAYAH 2',
            'email' => 'info@lldikti2.id',
            'alamat' => 'Jl. Srijaya Negara No. 883 Palembang 30153',
            'telepon' => '0822-8204-0372',
            'website' => 'https://lldiktiwilayah2.ristekdikti.go.id',
            'kota' => 'Palembang',
            'provinsi' => 'Sumatera Selatan',
            'kepala_kantor' => 'Ishak Iskandar',
            'nip_kepala_kantor' => '196303031990031002', // Contoh NIP, sesuaikan jika perlu
            'jabatan' => 'Kepala LLDIKTI Wilayah II',
            'logo' => null, // Anda bisa tambahkan path logo jika tersedia
            'tahun' => date('Y'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
