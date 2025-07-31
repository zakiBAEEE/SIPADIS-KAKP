<!DOCTYPE html>
<html>
<head>
    <title>Rekapitulasi Surat</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h3>Rekapitulasi Surat</h3>
    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Klasifikasi</th>
                <th>Jumlah Klasifikasi</th>
                <th>Sifat</th>
                <th>Jumlah Sifat</th>
                <th>Status</th>
                <th>Jumlah Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekapData as $row)
                <tr>
                    <td>{{ $row['waktu'] ?? '-' }}</td>
                    <td>{{ $row['klasifikasi'] ?? '-' }}</td>
                    <td>{{ $row['jumlah_klasifikasi'] ?? '-' }}</td>
                    <td>{{ $row['sifat'] ?? '-' }}</td>
                    <td>{{ $row['jumlah_sifat'] ?? '-' }}</td>
                    <td>{{ $row['status'] ?? '-' }}</td>
                    <td>{{ $row['jumlah_status'] ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
