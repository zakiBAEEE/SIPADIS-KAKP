<div
    class="relative flex flex-col w-full max-h-[400px] overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border h-[400px]">
    <table class="w-full text-left table-auto text-slate-800 min-w-0">
        <thead class="border-b border-slate-200 bg-slate-100 text-sm font-medium text-slate-600">
            <tr>
                <th class="px-2.5 py-2 text-start font-bold">
                    Name
                </th>
                <th class="px-2.5 py-2 text-start font-bold">
                    Username
                </th>
                <th class="px-2.5 py-2 text-start font-bold">
                    Role
                </th>
                <th class="px-2.5 py-2 text-start font-bold">
                    Tim Kerja
                </th>
                <th class="px-2.5 py-2 text-start font-bold">
                    Status
                </th>
                <th class="px-2.5 py-2 text-start font-bold">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody class="group text-sm text-slate-800">
            @forelse ($users as $user)
                <tr class="even:bg-slate-100">
                    <td class="p-3">
                        {{ $user->name }}
                    </td>
                    <td class="p-3">
                        {{ $user->username }}
                    </td>
                    <td class="p-3">
                        {{ $user->role->name }}
                    </td>
                    <td class="p-3">
                        @if ($user->timKerja && $user->timKerja->nama_timKerja)
                            {{ $user->timKerja->nama_timKerja }}
                        @else
                            --
                        @endif
                    </td>
                    <td class="p-3">
                        @if ($user->is_active)
                            <span class="bg-green-100 text-green-800 px-2 py-1 text-xs rounded-full">
                                Aktif
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 px-2 py-1 text-xs rounded-full">
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="p-3">
                        <div class="flex flex-row gap-x-1">
                            @include('components.modal.modal-edit-pegawai', [
                                'id' => $user->id,
                                'isActive' => $user->is_active,
                                'nama_lengkap' => $user->name,
                                'username' => $user->username,
                                'is_active' => $user->is_active,
                            ])
                            <form action="{{ route('pegawai.destroy', $user->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus pegawai ini?')">
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
