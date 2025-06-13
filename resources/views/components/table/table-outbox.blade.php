<div
    class="relative flex flex-col w-full max-h-[500px] overflow-y-auto text-gray-700 bg-white shadow-md rounded-lg bg-clip-border border border-gray-200">
    <table class="w-full text-left table-auto text-slate-800 min-w-max">

        {{-- ... (struktur div dan table sama persis) ... --}}
        <thead class="sticky top-0 z-10">
            <tr class="text-slate-600 ...">
                <th class="p-4">
                    <p>Tgl. Kirim</p>
                </th>
                <th class="p-4">
                    <p>Tujuan Disposisi</p>
                </th> {{-- <- PERUBAHAN 1: Judul Kolom --}}
                <th class="p-4">
                    <p>Perihal Surat</p>
                </th>
                <th class="p-4 text-center">
                    <p>Status di Penerima</p>
                </th> {{-- <- Judul Kolom Disesuaikan --}}
                <th class="p-4 text-center">
                    <p>Aksi</p>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($disposisis as $disposisi)
                <tr class="hover:bg-slate-50 ...">
                    <td class="p-4 align-top">
                        <p class="text-sm font-medium">
                            {{ \Carbon\Carbon::parse($disposisi->tanggal_disposisi)->translatedFormat('d M Y') }}</p>
                    </td>
                    <td class="p-4 align-top">
                        {{-- PERUBAHAN 2: Menampilkan PENERIMA, bukan pengirim --}}
                        <p class="text-sm font-medium">{{ $disposisi->penerima->name ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">{{ $disposisi->penerima->role->name ?? '' }}</p>
                    </td>
                    <td class="p-4 align-top">
                        <p class="text-sm">{{ $disposisi->surat->perihal ?? '...' }}</p>
                    </td>
                    <td class="p-4 align-top text-center">
                        {{-- Kolom status ini menjadi sangat berguna di Outbox --}}
                        @if ($disposisi->status === 'Terkirim')
                            <span class="... bg-blue-100 text-blue-800">Terkirim</span>
                        @elseif($disposisi->status === 'Dilihat')
                            <span class="... bg-gray-200 text-gray-800">Dilihat</span>
                        @else
                            <span class="... bg-green-100 text-green-800">{{ $disposisi->status }}</span>
                        @endif
                    </td>
                    <td class="p-4 align-top text-center">
                        <a href="{{ route('surat.show', $disposisi->surat_id) }}" class="...">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
            @empty
                {{-- ... --}}
            @endforelse
        </tbody>
    </table>
</div>
