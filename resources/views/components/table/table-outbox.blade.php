<div
    class="relative flex flex-col w-full max-h-[400px] overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border h-[400px]">

    <table class="w-full text-left table-auto text-slate-800 min-w-0">
        <thead>
            <tr class="text-slate-500 border-b border-slate-300 bg-slate-50">
                <th class="p-3">
                    <p class="text-sm leading-none font-normal">Tgl. Kirim</p>
                </th>
                <th class="p-3">
                    <p class="text-sm leading-none font-normal">Tujuan Disposisi</p>
                </th>
                <th class="p-3">
                    <p class="text-sm leading-none font-normal">Perihal Surat</p>
                </th>
                <th class="p-3 text-center">
                    <p class="text-sm leading-none font-normal">Status di Penerima</p>
                </th>
                <th class="p-3 text-center">
                    <p class="text-sm leading-none font-normal">Tipe Aksi</p>
                </th>
                <th class="p-3 text-center">
                    <p class="text-sm leading-none font-normal">Aksi</p>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($disposisis as $disposisi)
                <tr class="hover:bg-slate-50">
                    <td class="p-3">
                        <p class="text-sm font-medium">
                            {{ \Carbon\Carbon::parse($disposisi->created_at)->translatedFormat('d F Y H:i') }}
                        </p>
                    </td>
                    <td class="p-3">
                        <p class="text-sm font-medium">{{ $disposisi->penerima->name ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">{{ $disposisi->penerima->role->name ?? '' }}</p>
                    </td>
                    <td class="p-3">
                        <p class="text-sm">{{ $disposisi->suratMasuk->perihal ?? '...' }}</p>
                    </td>
                    <td class="p-3 text-center">
                        @if ($disposisi->status === 'Menunggu')
                            <span class="bg-yellow-100 text-gray-800 px-2 py-1 text-xs rounded-full">Menunggu</span>
                        @elseif($disposisi->status === 'Dilihat')
                            <span class="bg-blue-200 text-gray-800 px-2 py-1 text-xs rounded-full">Dilihat</span>
                        @elseif($disposisi->status === 'Dikembalikan')
                            <span class="bg-red-200 text-gray-800 px-2 py-1 text-xs rounded-full">Dikembalikan</span>
                        @else
                            <span
                                class="bg-green-100 text-green-800 px-2 py-1 text-xs rounded-full">{{ $disposisi->status }}</span>
                        @endif
                    </td>
                    <td class="p-3 text-center">
                        @if ($disposisi->tipe_aksi === 'Kembalikan')
                            <span class="bg-red-100 text-gray-800 px-2 py-1 text-xs rounded-full">Reject</span>
                        @elseif($disposisi->tipe_aksi === 'Teruskan')
                            <span class="bg-blue-200 text-gray-800 px-2 py-1 text-xs rounded-full">Teruskan</span>
                        @elseif($disposisi->tipe_aksi === 'Revisi')
                            <span class="bg-blue-200 text-gray-800 px-2 py-1 text-xs rounded-full">Revisi</span>
                        @endif
                    </td>
                    <td class="p-3 text-center">
                        <a href="{{ route('surat.show', $disposisi->surat_id) }}"
                            class="text-blue-600 hover:text-blue-900 text-sm underline">
                            Lihat Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-3 text-center text-sm text-gray-500">Menampilkan riwayat disposisi hari ini, gunakan filter untuk melihat data lainnya</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
