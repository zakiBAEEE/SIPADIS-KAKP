<div
    class="relative flex flex-col w-full sm:max-h-[450px] overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border sm:h-[450px] h-screen">
    <table class="w-full text-left table-auto text-slate-800 min-w-0">
        <thead>
            <tr class="text-slate-500 border-b border-slate-300 bg-slate-50">

                <th class="p-3">
                    <p class="text-sm leading-none font-normal">
                        Nomor Agenda
                    </p>
                </th>
                <th class="p-3">
                    <p class="text-sm leading-none font-normal">
                        Nomor Surat
                    </p>
                </th>
                <th class="p-3">
                    <p class="text-sm leading-none font-normal">
                        Pengirim
                    </p>
                </th>
                <th class="p-3">
                    <p class="text-sm leading-none font-normal">
                        Tgl Terima
                    </p>
                </th>
                <th class="p-3">
                    <p class="text-sm leading-none font-normal">
                        Tgl Surat
                    </p>
                </th>
                <th class="p-3">
                    <p class="text-sm leading-none font-normal">
                        Perihal
                    </p>
                </th>
                @if (auth()->user()->role->name === 'Admin')
                    <th class="p-3">
                        <p class="text-sm leading-none font-normal">
                            Aksi
                        </p>
                    </th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($surats as $surat)
                <tr class="hover:bg-slate-50 border-b border-slate-200 cursor-pointer"
                    onclick="window.location.href='{{ route('surat.show', ['surat' => $surat->id]) }}'">
                    <td class="p-3">
                        <p class="text-sm">{{ $surat->id }}</p>
                    </td>
                    <td class="p-3">
                        <p class="text-sm">{{ $surat->nomor_surat }}</p>
                    </td>
                    <td class="p-3">
                        <p class="text-sm">{{ $surat->pengirim }}</p>
                    </td>
                    <td class="p-3">
                        <p class="text-sm">
                            {{ \Carbon\Carbon::parse($surat->created_at)->translatedFormat('d F Y') }}</p>
                    </td>
                    <td class="p-3">
                        <p class="text-sm">
                            {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}</p>
                    </td>
                    <td class="p-3">
                        <p class="text-sm">{{ $surat->perihal }}</p>
                    </td>
                    @if (auth()->user()->role->name === 'Admin')
                        <td class="p-3">
                            <div class="flex flex-row gap-x-1">
                                {{-- Tampilkan tombol "Kirim ke Kepala" HANYA JIKA surat belum punya disposisi --}}
                                @if (!$surat->disposisis()->exists())
                                    <form method="POST" action="{{ route('surat.destroy', $surat->id) }}"
                                        class="inline-block"
                                        onsubmit="return confirm('PENTING: Menghapus surat ini akan menghapus seluruh data disposisi terkait. Apakah Anda yakin ingin melanjutkan?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="event.stopPropagation();" title="Hapus Surat">
                                            @include('components.base.ikon-hapus')
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
