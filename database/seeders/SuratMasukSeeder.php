<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;


class SuratMasukSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        $sifatList = ['Rahasia', 'Penting', 'Segera', 'Rutin'];
        $klasifikasiList = ['Umum', 'Pengaduan', 'Permintaan Informasi'];

        for ($i = 1; $i <= 100; $i++) {
            $tanggal = $faker->dateTimeBetween('2024-06-01', '2025-07-31');

            DB::table('surat_masuk')->insert([
                'id' => $i,
                'nomor_surat' => $faker->numerify('###/###/##'),
                'pengirim' => $faker->name,
                'asal_instansi' => $faker->company,
                'email_pengirim' => 'raihanmuhammaddzaky623@gmail.com',
                'tanggal_surat' => $tanggal->format('Y-m-d'),
                'perihal' => $faker->sentence(6),
                'klasifikasi_surat' => $faker->randomElement($klasifikasiList),
                'sifat' => $faker->randomElement($sifatList),
                'file_path' => 'surat/' . Str::uuid() . '.pdf',
                'created_at' => $tanggal,
                'status' => 'draft',
            ]);
        }
    }
}
