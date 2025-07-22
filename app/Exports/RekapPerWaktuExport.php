<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapPerWaktuExport implements FromView
{
    protected $data;
    protected $waktu;
    protected $groupBy;

    public function __construct($data, $waktu, $groupBy)
    {
        $this->data = $data;
        $this->waktu = $waktu;
        $this->groupBy = $groupBy;
    }

    public function view(): View
    {
        return view('exports.rekap-per-waktu', [
            'data' => $this->data,
            'waktu' => $this->waktu,
            'groupBy' => $this->groupBy,
        ]);
    }
}
