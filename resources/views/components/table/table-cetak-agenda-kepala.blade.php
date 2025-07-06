<div class="w-full text-black">
    <table class="table-auto w-full border border-collapse border-gray-800 text-sm">
        <thead>
            <tr class="bg-gray-200 border-b border-gray-800">
                @php
                    $headers = [
                        'No. Agenda',
                        'Tgl Terima',
                        'Pengirim',
                        'Tgl Srt',
                        'No Srt',
                        'Perihal',
                        'Tujuan Disposisi',
                        'Instruksi',
                    ];
                @endphp
                @foreach ($headers as $header)
                    <th class="border border-gray-800 px-2 py-2 text-left font-semibold">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($suratMasuk as $surat)
                @foreach ($surat->disposisis->where('status', '!=', 'Dikembalikan')->where('tipe_aksi', '!=', 'Kembalikan') as $disposisi)
                    <tr class="border-b border-gray-300">
                        <td class="border border-gray-800 px-2 py-2">{{ $surat->id }}</td>
                        <td class="border border-gray-800 px-2 py-2">
                            {{ \Carbon\Carbon::parse($surat->created_at)->translatedFormat('d M Y') }}</td>
                        <td class="border border-gray-800 px-2 py-2">{{ $surat->pengirim }}</td>
                        <td class="border border-gray-800 px-2 py-2">
                            {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d M Y') }}</td>
                        <td class="border border-gray-800 px-2 py-2">{{ $surat->nomor_surat }}</td>
                        <td class="border border-gray-800 px-2 py-2">{{ $surat->perihal }}</td>
                        <td class="border border-gray-800 px-2 py-2">
                            @if ($disposisi->penerima)
                                @php
                                    $penerima = $disposisi->penerima;
                                    $penerimaRole = $penerima->role->name ?? null;
                                @endphp
                                {{ $penerimaRole === 'Katimja' ? $penerima->divisi->nama_divisi ?? '-' : ucfirst($penerimaRole ?? '-') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="border border-gray-800 px-2 py-2">
                            {{ $disposisi->catatan ?? '-' }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
