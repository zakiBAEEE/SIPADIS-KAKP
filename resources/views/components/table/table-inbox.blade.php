<div
    class="relative flex flex-col w-full max-h-[400px] overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border h-[400px]">
    <table class="w-full text-left table-auto text-slate-800 min-w-0">
        <thead>
            <tr class="text-slate-500 border-b border-slate-300 bg-slate-50">
                <th class="p-3">
                    <p class="text-sm leading-none font-normal">Nomor & Tgl Surat</p>
                </th>
                <th class="p-3">
                    <p class="text-sm leading-none font-normal">Perihal</p>
                </th>
                <th class="p-3">
                    <p class="text-sm leading-none font-normal">Asal Surat</p>
                </th>
                <th class="p-3">
                    <p class="text-sm leading-none font-normal">Diterima Dari (Disposisi)</p>
                </th>
                <th class="p-3 text-center">
                    <p class="text-sm leading-none font-normal">Status</p>
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
                <tr class="hover:bg-slate-50 border-b border-slate-200">
                    {{-- Nomor & Tgl Surat --}}
                    <td class="p-3 align-top">
                        <p class="text-sm font-medium">{{ $disposisi->suratMasuk->nomor_surat ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($disposisi->suratMasuk->tanggal_surat)->translatedFormat('d M Y') }}
                        </p>
                    </td>

                    {{-- Perihal --}}
                    <td class="p-3 align-top">
                        <p class="text-sm">{{ $disposisi->suratMasuk->perihal ?? 'Perihal tidak ditemukan.' }}</p>
                    </td>

                    {{-- Asal Surat --}}
                    <td class="p-3 align-top">
                        <p class="text-sm">{{ $disposisi->suratMasuk->pengirim ?? 'N/A' }}</p>
                    </td>

                    {{-- Diterima Dari --}}
                    <td class="p-3 align-top">
                        <p class="text-sm font-medium">{{ $disposisi->pengirim->name ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($disposisi->created_at)->translatedFormat('d M Y, H:i') }}
                        </p>
                    </td>

                    {{-- Status --}}
                    <td class="p-3 align-top text-center">
                        <span class="px-3 py-1 text-xs font-bold rounded-full
                            @if ($disposisi->status === 'Menunggu') bg-yellow-100 text-gray-800
                            @elseif($disposisi->status === 'Dilihat') bg-blue-200 text-gray-800
                            @elseif($disposisi->status === 'Dikembalikan') bg-red-200 text-gray-800
                            @else bg-green-100 text-green-800
                            @endif">
                            {{ $disposisi->status }}
                        </span>
                    </td>

                    {{-- Tipe Aksi --}}
                    <td class="p-3 align-top text-center">
                        @if ($disposisi->tipe_aksi === 'Kembalikan')
                            <span class="text-xs font-medium px-2 py-1 rounded-full bg-red-100 text-gray-800">Reject</span>
                        @elseif($disposisi->tipe_aksi === 'Teruskan')
                            <span class="text-xs font-medium px-2 py-1 rounded-full bg-green-200 text-gray-800">Disposisi</span>
                        @elseif($disposisi->tipe_aksi === 'Revisi')
                            <span class="text-xs font-medium px-2 py-1 rounded-full bg-blue-200 text-gray-800">Revisi</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="p-3 align-top text-center">
                        <div class="flex flex-row justify-center gap-x-1">
                            <a href="{{ route('surat.show', ['surat' => $disposisi->surat_id]) }}">
                                @include('components.base.ikon-mata')
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center p-8 text-gray-500">
                        Tidak ada disposisi masuk untuk Anda saat ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
