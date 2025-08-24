<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SuratKategoriSheetExport implements FromArray, WithHeadings, WithTitle
{
    protected $surats;
    protected $field;
    protected $title;

    public function __construct($surats, $field, $title)
    {
        $this->surats = $surats;
        $this->field = $field;
        $this->title = $title;
    }

   
    public function array(): array
    {
        $grouped = collect($this->surats)->groupBy(function ($item) {
            return $item[$this->field] ?? '-';
        });

        $rows = [];

        foreach ($grouped as $value => $items) {
            $value = $value ?? '-'; // Pastikan tidak null

            // Tambahkan header pemisah yang jelas antar kategori
            $value = $value ?? '-'; // Pastikan tidak null
            $rows[] = [$this->title . ': ' . $value];
            $rows[] = $this->headings();

            foreach ($items as $surat) {
                $rows[] = [
                    $surat->nomor_surat ?? '-',
                    $surat->tanggal_surat ?? '-',
                    $surat->asal_instansi ?? '-',
                    $surat->perihal ?? '-',
                    $surat->klasifikasi_surat ?? '-',
                    $surat->sifat ?? '-',
                    $surat->status ?? '-',
                ];
            }

            $rows[] = ['']; // baris kosong antar kelompok
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Nomor Surat',
            'Tanggal Surat',
            'Pengirim',
            'Perihal',
            'Klasifikasi',
            'Sifat',
            'Status',
        ];
    }

    public function title(): string
    {
        return $this->title;
    }
}
