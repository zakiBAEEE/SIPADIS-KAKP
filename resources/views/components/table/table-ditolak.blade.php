<div
    class="relative flex flex-col w-full sm:max-h-[450px] overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border sm:h-[450px] h-screen">
    <table class="w-full text-left table-auto text-slate-800 min-w-0">
        <thead>
            <tr class="text-slate-500 border-b border-slate-300 bg-slate-50">
                <th class="p-3 w-2/12">
                    <p class="text-sm leading-none font-normal">Dikembalikan Oleh</p>
                </th>
                <th class="p-3 w-3/12">
                    <p class="text-sm leading-none font-normal">Perihal Surat</p>
                </th>
                <th class="p-3 w-5/12">
                    <p class="text-sm leading-none font-normal">Alasan Pengembalian / Catatan</p>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($disposisis as $disposisi)
                <tr class="hover:bg-slate-50 border-b border-slate-200 cursor-pointer"
                    onclick="window.location.href='{{ route('surat.show', ['surat' => $disposisi->surat_id]) }}'">
                    <td class="p-3 align-top">
                        <p class="text-sm font-medium">{{ $disposisi->pengirim->name ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($disposisi->created_at)->translatedFormat('d M Y') }}
                        </p>
                    </td>
                    <td class="p-3 align-top">
                        <p class="text-sm">{{ $disposisi->suratMasuk->perihal ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">No. Surat:
                            {{ $disposisi->suratMasuk->nomor_surat ?? 'N/A' }}
                        </p>
                    </td>
                    <td class="p-3 align-top">
                        <p class="text-sm text-red-600 italic">"{{ $disposisi->catatan }}"</p>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center p-8 text-gray-500">
                        Tidak ada surat yang perlu direvisi saat ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
