<div
    class="relative flex flex-col w-full sm:max-h-[450px] overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border sm:h-[400px] h-screen">
    <table class="w-full text-left table-auto text-slate-800 min-w-0">
        <thead>
            <tr class=""text-slate-500 border-b border-slate-300 bg-slate-50">
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
                    <th class="  px-3 py-5 text-left text-slate-500 bg-slate-100">
                        <p class="text-sm leading-none font-semibold whitespace-normal break-words">
                            {{ $header }}
                        </p>
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($suratMasuk as $surat)
                @foreach ($surat->disposisis->where('status', '!=', 'Dikembalikan')->where('tipe_aksi', '!=', 'Kembalikan') as $disposisi)
                    <tr onclick="window.location='{{ route('surat.show', ['surat' => $surat->id]) }}'"
                        class="cursor-pointer hover:bg-blue-100">
                        <td class="p-3">
                            {{ $surat->id }}
                        </td>
                        <td class="p-3">
                            {{ \Carbon\Carbon::parse($surat->created_at)->translatedFormat('d M Y') }}
                        </td>
                        <td class="p-3">
                            {{ $surat->pengirim }}
                        </td>
                        <td class="p-3">
                            {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d M Y') }}
                        </td>
                        <td class="p-3">
                            {{ $surat->nomor_surat }}
                        </td>
                        <td class="p-3">
                            {{ $surat->perihal }}
                        </td>

                        <td class="p-3">
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

                        <td class="p-3">
                            {{ $disposisi->catatan ?? '-' }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
