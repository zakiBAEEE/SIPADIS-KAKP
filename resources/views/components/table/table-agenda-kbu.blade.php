<div
    class="relative flex flex-col w-full max-h-[400px] overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border h-[400px]">

    <table class="w-full text-left table-auto text-slate-800 min-w-0">
        {{-- THEAD YANG DIMODIFIKASI --}}
        <thead>
            <tr class="text-slate-500 border-b border-slate-300 bg-slate-50">
                @php
                    $headers = ['No. Agenda', 'Tgl Terima', 'Pengirim', 'Tgl Srt', 'No Srt', 'Perihal'];

                    $headers[] = 'Disposisi';
                    $headers[] = 'Tgl';
                    $headers[] = 'Tujuan Disposisi';
                    $headers[] = 'Instruksi';

                @endphp
                @foreach ($headers as $header)
                    <th class="p-3 text-left">

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
                    <tr class="hover:bg-slate-50 cursor-pointer"
                        onclick="window.location='{{ route('surat.show', $surat->id) }}'">

                        <td class="p-3">
                            <p class="text-sm">{{ $surat->id ?? '-' }}</p>
                        </td>
                        <td class="p-3">
                            <p class="text-sm">
                                {{ $surat->created_at ? \Carbon\Carbon::parse($surat->created_at)->translatedFormat('d M Y') : '-' }}
                            </p>
                        </td>
                        <td class="p-3">
                            <p class="text-sm">{{ $surat->pengirim ?? '-' }}</p>
                        </td>
                        <td class="p-3">
                            <p class="text-sm">
                                {{ $surat->tanggal_surat ? \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d M Y') : '-' }}
                            </p>
                        </td>
                        <td class="p-3">
                            <p class="text-sm">{{ $surat->nomor_surat ?? '-' }}</p>
                        </td>
                        <td class="p-3">
                            <p class="text-sm">{{ $surat->perihal ?? '-' }}</p>
                        </td>

                        @php
                            $disposisis = $surat->disposisis
                                ->where('status', '!=', 'Dikembalikan')
                                ->where('tipe_aksi', '!=', 'Kembalikan')
                                ->values()
                                ->take(3);
                        @endphp

                        {{-- Kolom Disposisi (Pengirim) --}}
                        <td class="p-3">
                            <p class="text-sm">
                                @if ($disposisi && $disposisi->pengirim)
                                    @php
                                        $pengirim = $disposisi->pengirim;
                                        $pengirimRole = $pengirim->role->name ?? null;
                                    @endphp
                                    {{ $pengirimRole === 'katimja' ? $pengirim->divisi->nama_divisi ?? '-' : ucfirst($pengirimRole ?? '-') }}
                                @else
                                    -
                                @endif
                            </p>
                        </td>

                        {{-- Kolom Tanggal Disposisi --}}
                        <td class="p-3">
                            <p class="text-sm">
                                {{ $disposisi && $disposisi->created_at ? \Carbon\Carbon::parse($disposisi->created_at)->translatedFormat('d M Y') : '-' }}
                            </p>
                        </td>

                        {{-- Kolom Tujuan Disposisi --}}
                        <td class="p-3">
                            <p class="text-sm">
                                @if ($disposisi && $disposisi->penerima)
                                    @php
                                        $penerima = $disposisi->penerima;
                                        $penerimaRole = $penerima->role->name ?? null;
                                    @endphp
                                    {{ $penerimaRole === 'Katimja' ? $penerima->divisi->nama_divisi ?? '-' : ucfirst($penerimaRole ?? '-') }}
                                @else
                                    -
                                @endif
                            </p>
                        </td>

                        {{-- Kolom Instruksi --}}
                        <td class="p-3">
                            <p class="text-sm">{{ $disposisi?->catatan ?? '-' }}</p>
                        </td>

                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
