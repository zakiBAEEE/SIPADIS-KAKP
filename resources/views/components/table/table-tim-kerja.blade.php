<div
    class="relative flex flex-col w-full max-h-[400px] overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border h-[400px]">
    <table class="w-full text-left table-auto text-slate-800 min-w-0">
        <thead class="border-b border-slate-200 bg-slate-100 text-sm font-medium text-slate-600">
            <tr>
                <th class="px-2.5 py-2 text-start font-bold">
                    Id
                </th>
                <th class="px-2.5 py-2 text-start font-bold">
                    Nama Tim Kerja
                </th>
                <th>
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody class="group text-sm text-slate-800">
            @forelse ($timKerja as $item)
                <tr class="even:bg-slate-100">
                    <td class="p-3">
                        {{ $item->id }}
                    </td>
                    <td class="p-3">
                        {{ $item->nama_divisi }}
                    </td>
                    <td class="p-3">
                        <div class="flex flex-row gap-x-1">
                            @include('components.layout.modal-edit-tim-kerja', [
                                'id' => $item->id,
                                'namaDivisi' => $item->nama_divisi,
                            ])
                            <form action="{{ route('tim-kerja.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus tim kerja ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    @include('components.base.ikon-hapus')
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center p-3">Belum ada disposisi.</td>

                </tr>
            @endforelse
        </tbody>


    </table>
</div>
