<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapitulasiExport implements FromArray, WithHeadings
{
    protected $rekapData;

    public function __construct(array $rekapData)
    {
        $this->rekapData = $rekapData;
    }

    public function array(): array
    {
        return $this->rekapData;
    }

    public function headings(): array
    {
        return [
            'Waktu',
            'Klasifikasi',
            'Jumlah Klasifikasi',
            'Sifat',
            'Jumlah Sifat',
            'Status',
            'Jumlah Status',
        ];
    }
}
