<div class="relative flex flex-col w-full ...">
    <table class="w-full text-left table-auto ...">
        <thead class="sticky top-0 ...">
            <tr>
                <th class="p-4 w-2/12">
                    <p>Dikembalikan Oleh</p>
                </th>
                <th class="p-4 w-3/12">
                    <p>Perihal Surat</p>
                </th>
                <th class="p-4 w-5/12">
                    <p>Alasan Pengembalian / Catatan</p>
                </th>
                <th class="p-4 w-2/12 text-center">
                    <p>Aksi</p>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($disposisis as $disposisi)
                <tr class="hover:bg-slate-50 ...">
                    <td class="p-4 align-top">
                        <p class="font-medium">{{ $disposisi->pengirim->name ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($disposisi->tanggal_disposisi)->translatedFormat('d M Y') }}</p>
                    </td>
                    <td class="p-4 align-top">
                        <p class="text-sm">{{ $disposisi->suratMasuk->perihal ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">No. Surat: {{ $disposisi->suratMasuk->nomor_surat ?? 'N/A' }}
                        </p>
                    </td>
                    <td class="p-4 align-top">
                        {{-- Ini adalah kolom paling penting di halaman ini --}}
                        <p class="text-sm text-red-600 italic">"{{ $disposisi->catatan }}"</p>
                    </td>
                    <td class="p-4 align-top text-center">
                        <div class="flex flex-row gap-x-1">
                            {{-- Tombol ini akan memicu pengiriman ulang --}}
                            <a href="{{ route('surat.show', ['surat' => $disposisi->surat_id]) }}">
                                @include('components.base.ikon-mata')
                            </a>
                            <a href="{{ route('surat.edit', ['surat' => $disposisi->surat_id]) }}">
                                @include('components.base.ikon-edit')
                            </a>

                            @if (in_array(auth()->user()->role->name, ['Admin']))
                                <form method="POST"
                                    action="{{ route('surat.kirimUlangKeKepala', $disposisi->surat_id) }}"
                                    onsubmit="return confirm('Anda yakin ingin mengirim ulang surat ini setelah direvisi?');">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 bg-green-600 text-white rounded-md text-xs font-semibold hover:bg-green-700">
                                        Kirim Ulang
                                    </button>
                                </form>
                            @endif
                        </div>

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
