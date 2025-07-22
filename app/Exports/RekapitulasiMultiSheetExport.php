<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RekapitulasiMultiSheetExport implements WithMultipleSheets
{
    protected $surats;

    public function __construct($rekapData, $surats)
    {
        $this->surats = $surats;
        $this->rekapData = $rekapData;
    }

    public function sheets(): array
    {
        return [
            new RekapitulasiExport($this->rekapData),
            new SuratKategoriSheetExport($this->surats, 'klasifikasi_surat', 'Klasifikasi'),
            new SuratKategoriSheetExport($this->surats, 'sifat', 'Sifat'),
            new SuratKategoriSheetExport($this->surats, 'status', 'Status'),
        ];
    }
}
