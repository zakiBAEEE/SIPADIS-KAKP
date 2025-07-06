<div class="relative flex flex-col w-full text-black">
    <table class="w-full table-auto text-left text-slate-800 border border-collapse border-gray-800 text-sm">
        {{-- THEAD YANG DIMODIFIKASI --}}
        <thead>
            <tr class="bg-gray-200 border-b border-gray-800">
                @php
                    $headers = ['No. Agenda', 'Tgl Terima', 'Pengirim', 'Tgl Srt', 'No Srt', 'Perihal'];
                    $headers[] = 'Disposisi';
                    $headers[] = 'Tgl';
                    $headers[] = 'Tujuan Disposisi';
                    $headers[] = 'Instruksi';
                @endphp
                @foreach ($headers as $header)
                    <th class="p-2 border border-gray-800 font-semibold text-left">
                        <p class="text-sm leading-none whitespace-normal break-words">
                            {{ $header }}
                        </p>
                    </th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach ($suratMasuk as $surat)
                @foreach ($surat->disposisis->where('status', '!=', 'Dikembalikan')->where('tipe_aksi', '!=', 'Kembalikan') as $disposisi)
                    <tr class="border-b border-gray-300">
                        <td class="p-2 border border-gray-800">
                            <p class="text-sm">{{ $surat->id ?? '-' }}</p>
                        </td>
                        <td class="p-2 border border-gray-800">
                            <p class="text-sm">
                                {{ $surat->created_at ? \Carbon\Carbon::parse($surat->created_at)->translatedFormat('d M Y') : '-' }}
                            </p>
                        </td>
                        <td class="p-2 border border-gray-800">
                            <p class="text-sm">{{ $surat->pengirim ?? '-' }}</p>
                        </td>
                        <td class="p-2 border border-gray-800">
                            <p class="text-sm">
                                {{ $surat->tanggal_surat ? \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d M Y') : '-' }}
                            </p>
                        </td>
                        <td class="p-2 border border-gray-800">
                            <p class="text-sm">{{ $surat->nomor_surat ?? '-' }}</p>
                        </td>
                        <td class="p-2 border border-gray-800">
                            <p class="text-sm">{{ $surat->perihal ?? '-' }}</p>
                        </td>

                        @php
                            $disposisis = $surat->disposisis
                                ->where('status', '!=', 'Dikembalikan')
                                ->where('tipe_aksi', '!=', 'Kembalikan')
                                ->values()
                                ->take(3);
                        @endphp

                        <td class="p-2 border border-gray-800">
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

                        <td class="p-2 border border-gray-800">
                            <p class="text-sm">
                                {{ $disposisi && $disposisi->created_at ? \Carbon\Carbon::parse($disposisi->created_at)->translatedFormat('d M Y') : '-' }}
                            </p>
                        </td>

                        <td class="p-2 border border-gray-800">
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

                        <td class="p-2 border border-gray-800">
                            <p class="text-sm">{{ $disposisi?->catatan ?? '-' }}</p>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
