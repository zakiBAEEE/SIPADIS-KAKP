<div
    class="relative flex flex-col w-full max-h-[500px] overflow-y-auto text-gray-700 bg-white shadow-md rounded-lg bg-clip-border border border-gray-200">
    <table class="w-full text-left table-auto text-slate-800 min-w-max">

        <thead class="sticky top-0 z-10">
            <tr class="text-slate-600 border-b border-slate-300 bg-slate-100">
                <th class="p-4">
                    <p class="text-sm leading-none font-semibold">Nomor & Tgl Surat</p>
                </th>
                <th class="p-4">
                    <p class="text-sm leading-none font-semibold">Perihal</p>
                </th>
                <th class="p-4">
                    <p class="text-sm leading-none font-semibold">Asal Surat</p>
                </th>
                <th class="p-4">
                    <p class="text-sm leading-none font-semibold">Diterima Dari (Disposisi)</p>
                </th>
                <th class="p-4 text-center">
                    <p class="text-sm leading-none font-semibold">Status</p>
                </th>
                <th class="p-4 text-center">
                    <p class="text-sm leading-none font-semibold">Aksi</p>
                </th>
            </tr>
        </thead>

        <tbody>
            @forelse ($disposisis as $disposisi)
                <tr class="hover:bg-slate-50 even:bg-white odd:bg-slate-50 border-b border-slate-200">

                    {{-- Kolom Nomor Surat (diambil dari relasi) --}}
                    <td class="p-4 align-top">
                        <p class="text-sm font-medium">{{ $disposisi->suratMasuk->nomor_surat ?? 'N/A' }}</p>
                    </td>

                    {{-- Kolom Tanggal Surat (diambil dari relasi) --}}
                    <td class="p-4 align-top">
                        <p class="text-sm">
                            {{ \Carbon\Carbon::parse($disposisi->suratMasuk->tanggal_surat)->translatedFormat('d M Y') }}
                        </p>
                    </td>

                    {{-- Kolom Perihal (diambil dari relasi) --}}
                    <td class="p-4 align-top">
                        <p class="text-sm">{{ $disposisi->suratMasuk->perihal ?? 'Perihal tidak ditemukan.' }}</p>
                    </td>

                    {{-- Kolom Asal Disposisi (diambil dari relasi) --}}
                    <td class="p-4 align-top">
                        <p class="text-sm font-medium">{{ $disposisi->pengirim->name ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($disposisi->tanggal_disposisi)->translatedFormat('d M Y, H:i') }}
                        </p>
                    </td>

                    {{-- Kolom Status Disposisi (langsung dari disposisi) --}}
                    <td class="p-4 align-top text-center">
                        <span class="px-3 py-1 text-xs font-bold ...">{{ $disposisi->status }}</span>
                    </td>

                    {{-- Kolom Aksi --}}
                    <td class="p-4 align-top text-center">
                        <div class="flex flex-row gap-x-1">
                            <a href="{{ route('surat.show', ['surat' => $disposisi->surat_id]) }}" class="...">
                                @include('components.base.ikon-mata')
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center p-8 text-gray-500">
                        Tidak ada disposisi masuk untuk Anda saat ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
