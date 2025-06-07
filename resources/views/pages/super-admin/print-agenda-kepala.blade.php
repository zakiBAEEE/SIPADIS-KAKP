<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Agenda Terima</title>
    @vite('resources/css/app.css')
    <style>
        @media print {
            @page {
                size: landscape;
            }
        }
    </style>
</head>

<body onload="window.print()" class="text-[9px] font-sans p-4 bg-white text-black">
    <h2 class="text-center text-base font-bold mb-4 uppercase">Cetak Agenda Terima</h2>
    <div class="overflow-x-auto">
        @include('components.table.table-agenda-kepala', ['suratMasuk' => $suratMasuk])
    </div>
</body>

</html>
