<div
    class="relative flex flex-col w-full max-h-[400px] overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border h-[400px]">

    <table class="w-full text-left table-auto text-slate-800 min-w-0">
        {{-- THEAD YANG DIMODIFIKASI --}}
        <thead>
            <tr class="text-slate-500 border-b border-slate-300 bg-slate-50">
                @php
                    $headers = ['No. Agenda', 'Tgl Terima', 'Pengirim', 'Tgl Srt', 'No Srt', 'Perihal'];

                    for ($i = 1; $i <= 3; $i++) {
                        $headers[] = 'Disposisi';
                        $headers[] = 'Tgl';
                        $headers[] = 'Tujuan Disposisi';
                        $headers[] = 'Instruksi';
                        $headers[] = 'Paraf';
                    }
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
        {{-- Akhir THEAD YANG DIMODIFIKASI --}}

      {{-- Pastikan ini adalah bagian dari tabel yang sama dengan <thead> yang sudah dimodifikasi sebelumnya --}}
<tbody>
    @foreach ($suratMasuk as $surat)
        {{-- Modifikasi kelas pada <tr> --}}
        <tr class="hover:bg-slate-50">

            {{-- Modifikasi kelas pada <td> dan pembungkusan konten dengan <p> --}}
            <td class="p-3">
                <p class="text-sm">{{ $surat->nomor_agenda ?? '-' }}</p>
            </td>
            <td class="p-3">
                <p class="text-sm">{{ $surat->tanggal_terima ? \Carbon\Carbon::parse($surat->tanggal_terima)->translatedFormat('d M Y') : '-' }}</p>
            </td>
            <td class="p-3">
                <p class="text-sm">{{ $surat->pengirim ?? '-' }}</p>
            </td>
            <td class="p-3">
                <p class="text-sm">{{ $surat->tanggal_surat ? \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d M Y') : '-' }}</p>
            </td>
            <td class="p-3">
                <p class="text-sm">{{ $surat->nomor_surat ?? '-' }}</p>
            </td>
            <td class="p-3">
                <p class="text-sm">{{ $surat->perihal ?? '-' }}</p>
            </td>

            @php
                $disposisis = $surat->disposisis->take(3);
            @endphp

            @for ($i = 0; $i < 3; $i++)
                @php
                    $disposisi = $disposisis[$i] ?? null;
                @endphp

                {{-- Kolom Disposisi (Pengirim) --}}
                <td class="p-3">
                    <p class="text-sm">
                        @if ($disposisi && $disposisi->pengirim)
                            @php
                                $pengirim = $disposisi->pengirim;
                                $pengirimRole = $pengirim->role->name ?? null;
                            @endphp
                            {{ $pengirimRole === 'katimja' ? ($pengirim->divisi->nama_divisi ?? '-') : ucfirst($pengirimRole ?? '-') }}
                        @else
                            -
                        @endif
                    </p>
                </td>

                {{-- Kolom Tanggal Disposisi --}}
                <td class="p-3">
                    <p class="text-sm">
                        {{ $disposisi && $disposisi->tanggal_disposisi ? \Carbon\Carbon::parse($disposisi->tanggal_disposisi)->translatedFormat('d M Y') : '-' }}
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
                            {{ $penerimaRole === 'katimja' ? ($penerima->divisi->nama_divisi ?? '-') : ucfirst($penerimaRole ?? '-') }}
                        @else
                            -
                        @endif
                    </p>
                </td>

                {{-- Kolom Instruksi --}}
                <td class="p-3">
                    <p class="text-sm">{{ $disposisi?->catatan ?? '-' }}</p>
                </td>

                {{-- Kolom Paraf --}}
                <td class="p-3">
                    <p class="text-sm">&nbsp;</p> {{-- Menggunakan &nbsp; agar sel tetap memiliki tinggi yang konsisten --}}
                </td>
            @endfor
        </tr>
    @endforeach
</tbody>
    </table>
</div>