<div
    class="relative flex flex-col w-full max-h-[400px] overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border h-[400px]">
    <table class="w-full text-left table-auto text-slate-800 min-w-0">
        <thead class="border-b border-slate-200 bg-slate-100 text-sm font-medium text-slate-600">
            <tr>
                <th class="px-2.5 py-2 text-start font-bold">
                    Tanggal
                </th>
                <th class="px-2.5 py-2 text-start font-bold">
                    Disposisi Dari
                </th>
                <th class="px-2.5 py-2 text-start font-bold">
                    Instruksi
                </th>
                <th class="px-2.5 py-2 text-start font-bold">
                    Tujuan Disposisi
                </th>
            </tr>
        </thead>

        <tbody class="group text-sm text-slate-800">
            @forelse ($surat->disposisis as $disposisi)
                <tr class="even:bg-slate-100">
                    <td class="p-3">
                        {{ \Carbon\Carbon::parse($disposisi->created_at)->translatedFormat('d F Y H:i') }}
                    </td>
                    <td class="p-3">
                        @if ($disposisi->pengirim && $disposisi->pengirim->timKerja)
                            {{ $disposisi->pengirim->timKerja->nama_timKerja }}
                            ({{ $disposisi->pengirim->role->name }})
                            || {{ $disposisi->pengirim->name }}
                        @else
                            {{ $disposisi->pengirim->role->name ?? '-' }} || {{ $disposisi->pengirim->name }}
                        @endif
                    </td>
                    <td class="p-3">
                        {{ $disposisi->catatan }}
                    </td>
                    <td class="p-3">
                        @if ($disposisi->penerima && $disposisi->penerima->timKerja)
                            {{ $disposisi->penerima->timKerja->nama_timKerja }} ({{ $disposisi->penerima->role->name }}) ||
                            {{ $disposisi->penerima->name }}
                        @else
                            {{ $disposisi->penerima->role->name ?? '-' }} || {{ $disposisi->penerima->name }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center p-3">Belum ada disposisi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
