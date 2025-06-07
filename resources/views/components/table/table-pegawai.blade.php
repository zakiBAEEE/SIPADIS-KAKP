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
                    Password
                </th>
                <th class="px-2.5 py-2 text-start font-bold">
                    Role
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
                        {{ $user->password }}
                    </td>
                    <td class="p-3">
                        @if ($user->divisi && $user->divisi->nama_divisi)
                            {{ $user->divisi->nama_divisi }}
                        @else
                            {{ $user->role->name ?? '-' }}
                        @endif
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
