<div
    class="relative flex flex-col w-full sm:max-h-[450px] overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border sm:h-[450px] h-screen">
    <table class="w-full text-left table-auto text-slate-800 min-w-0">
        <thead>
            <tr class="text-slate-500 border-b border-slate-300 bg-slate-50">

                <th class="p-3 hidden">
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
                        Instansi Pengirim
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
                <th class="p-3">
                    <p class="text-sm leading-none font-normal">
                        Disposisi Terakhir
                    </p>
                </th>
                <th class="p-3">
                    <p class="text-sm leading-none font-normal">
                        Status
                    </p>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($surats as $surat)
                <tr class="hover:bg-slate-50 border-b border-slate-200 cursor-pointer"
                    onclick="window.location.href='{{ route('surat.show', ['surat' => $surat->id]) }}'">
                    <td class="p-3 hidden">
                        <p class="text-sm">{{ $surat->id }}</p>
                    </td>
                    <td class="p-3">
                        <p class="text-sm">{{ $surat->nomor_surat }}</p>
                    </td>
                    <td class="p-3">
                        <p class="text-sm">{{ $surat->asal_instansi }}</p>
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
                    <td class="p-3">
                        @php
                            $lastDisposisi = $surat->disposisis->last();
                            $role = $lastDisposisi->penerima->role->name;
                        @endphp

                        @if ($role == 'Katimja' || $role == 'Staf')
                            <p class="text-sm">{{ $lastDisposisi->penerima->timKerja->nama_timKerja }}
                        @else
                            <p class="text-sm">{{ $lastDisposisi->penerima->role->name }} ||
                                {{ $lastDisposisi->penerima->name }}</p>
                        @endif
                    </td>
                    <td class="p-3">
                        @php
                            $status = $surat->status;
                            $badgeClass = match ($status) {
                                'diproses' => 'bg-yellow-100 text-yellow-800',
                                'selesai' => 'bg-green-100 text-green-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp

                        <span class="px-3 py-1 text-sm font-medium rounded-full {{ $badgeClass }}">
                            @if ($surat->status == 'diproses')
                                Diproses
                            @else
                                Selesai
                            @endif
                        </span>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
