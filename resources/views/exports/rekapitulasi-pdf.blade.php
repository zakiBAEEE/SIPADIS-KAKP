<!DOCTYPE html>
<html>

<head>
    <title>Rekapitulasi Surat</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        h3,
        h4 {
            margin-bottom: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            margin-bottom: 12px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f0f0f0;
        }

        .page-break {
            page-break-after: always;
        }

        .section-header {
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 19px;
            font-weight: bold;
        }

        .sub-kategori {
            font-size: 14px;
            font-weight: bold;
            margin-top: 12px;
        }

        .section-header1 {
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 23px;
            font-weight: bold;
            margin: auto;
            width: 100%;
            text-align: center;
        }

        .section-header2 {
            margin-top: 25px;
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: bold;
            margin: auto;
            width: 100%;
            text-align: center;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            font-size: 10px;
            color: #555;
            border-top: 1px solid #ccc;
            padding: 6px 30px 4px 30px;
            background: #fff;
        }



        .ttd-fixed {
            position: fixed;
            bottom: 80px;
            right: 30px;
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>

<body>

    {{-- KOP SURAT --}}
    <table width="80%" style="border-bottom: 2px solid #000000; margin-bottom: 10px;">
        <tr>
            <td style="width: 100px; vertical-align: middle; border-color: transparent">
                <img src="{{ public_path('storage/' . $lembaga->logo) }}" alt="Logo" style="width: 120px;">
            </td>
            <td style="border-color: transparent">
                <div style="text-align: center; line-height: 1.4;">
                    <div style="font-size: 20px; font-weight: bold;">{{ strtoupper($lembaga->nama_kementerian) }}</div>
                    <div style="font-size: 16px; font-weight: bold;">{{ strtoupper($lembaga->nama_lembaga) }}</div>
                    <div style="font-size: 14px;">{{ $lembaga->alamat }}</div>
                    <div style="font-size: 14px;">Laman: {{ $lembaga->website }}</div>
                    <div style="font-size: 14px;">Telepon: {{ $lembaga->telepon }}</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-header1">Rekapitulasi Surat Masuk</div>
    <div class="section-header2">{{ $waktu }}</div>

    {{-- LOOP PER KATEGORI --}}
    @foreach (['Klasifikasi', 'Sifat', 'Status', 'Divisi'] as $i => $kategori)
        <div class="section-header">Kategori: {{ $kategori }}</div>

        @foreach ($rekap[$kategori] as $label => $items)
            <div class="sub-kategori">{{ $label }} ({{ $items->count() }} surat)</div>
            <table>
                <thead>
                    <tr>
                        <th>Nomor Surat</th>
                        <th>Pengirim</th>
                        <th>Asal Instansi</th>
                        <th>Tgl Terima</th>
                        <th>Tgl Surat</th>
                        <th>Perihal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $surat)
                        <tr>
                            <td>{{ $surat->nomor_surat }}</td>
                            <td>{{ $surat->pengirim }}</td>
                            <td>{{ $surat->asal_instansi }}</td>
                            <td>{{ \Carbon\Carbon::parse($surat->created_at)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d-m-Y') }}</td>
                            <td>{{ $surat->perihal }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach

        @if ($i < 3)
            <div class="page-break"></div>
        @endif
    @endforeach

    {{-- TANDA TANGAN + FOOTER di halaman terakhir --}}
    <div style="page-break-inside: avoid; margin-top: 40px;">
        <div class="ttd-fixed">
            <div style="padding: 4px">
                Palembang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </div>
            <div style="margin-top: 0; padding: 4px;">
                Kepala LLDIKTI Wilayah II
            </div>
            <br><br><br><br>
            <div style="font-weight: bold; text-decoration: underline;">
                Prof. Dr. Iskhaq Iskandar, M.Sc
            </div>
        </div>
    </div>

    <div class="footer">
        <span>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}</span>
        <span style="float: right;">SIPADIS - Sistem Pengarsipan Digital Surat</span>
    </div>

</body>

</html>
