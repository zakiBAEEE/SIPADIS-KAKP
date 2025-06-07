<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Agenda Surat Masuk</title>
    @vite('resources/css/app.css')
    <style>
        @media print {
            @page {
                size: landscape;
                margin: 1cm;
            }
        }

        body {
            font-size: 9px;
        }

        table th,
        table td {
            font-size: 8px;
        }
    </style>
</head>

<body onload="window.print()" class="font-sans p-4 bg-white text-black">
    <h2 class="text-center text-sm font-bold mb-4 uppercase">Cetak Agenda Surat Masuk</h2>
    <div class="overflow-x-auto">
        {{-- @include('components.table.table-cetak-agenda-kbu', ['suratMasuk' => $suratMasuk]) --}}
        @include('components.table.table-agenda-kbu', ['suratMasuk' => $suratMasuk])
    </div>
</body>
</html>
