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
                    <p class="text-sm leading-none font-normal">Asal Instansi</p>
                </th>
                <th class="p-3">
                    <p class="text-sm leading-none font-normal">Diterima Dari (Disposisi)</p>
                </th>
                <th class="p-3 text-center">
                    <p class="text-sm leading-none font-normal">Status</p>
                </th>
                @php
                    $userRole = strtolower(auth()->user()->role->name);
                @endphp

                @if ($userRole !== 'staf')
                    <th class="p-3 text-center">
                        <p class="text-sm leading-none font-normal">Tipe Aksi</p>
                    </th>
                @endif

            </tr>
        </thead>

        <tbody>
            @forelse ($disposisis as $disposisi)
                <tr class="hover:bg-slate-50 cursor-pointer"
                    onclick="window.location='{{ route('surat.show', $disposisi->surat_id) }}'">
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
                        <p class="text-sm">{{ $disposisi->suratMasuk->asal_instansi ?? 'N/A' }}</p>
                    </td>

                    {{-- Diterima Dari --}}
                    <td class="p-3 align-top">
                        <p class="text-sm font-medium">{{ $disposisi->pengirim->name ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($disposisi->created_at)->translatedFormat('d M Y, H:i') }}
                        </p>
                    </td>

                    {{-- Status --}}
                    <td class="p-3 text-center">
                        @php
                            $userRole = strtolower(auth()->user()->role->name);
                        @endphp

                        @if ($userRole !== 'staf')
                            @php
                                $status = ucwords(strtolower(trim($disposisi->status))); // status dari disposisi
                                $statusClass = 'bg-gray-100 text-gray-800'; // Default warna

                                if ($status === 'Menunggu') {
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                } elseif ($status === 'Dilihat') {
                                    $statusClass = 'bg-blue-100 text-blue-800';
                                }
                            @endphp

                            <span class="{{ $statusClass }} px-2 py-1 text-xs rounded-full">
                                {{ $status }}
                            </span>
                        @else
                            @php
                                $suratStatus = ucwords(strtolower(trim($disposisi->suratMasuk->status))); // status dari surat
                                $suratStatusClass = match (strtolower($disposisi->suratMasuk->status)) {
                                    'diproses' => 'bg-yellow-100 text-yellow-800',
                                    'ditindaklanjuti' => 'bg-blue-100 text-blue-800',
                                    'selesai' => 'bg-green-100 text-green-800',
                                    'dikembalikan' => 'bg-red-100 text-red-800',
                                    'ditolak' => 'bg-gray-200 text-gray-800',
                                    default => 'bg-slate-100 text-slate-700',
                                };
                            @endphp

                            <span class="{{ $suratStatusClass }} px-2 py-1 text-xs rounded-full">
                                {{ $suratStatus }}
                            </span>
                        @endif
                    </td>


                    {{-- Tipe Aksi --}}
                    @if ($userRole !== 'staf')
                        <td class="p-3 text-center">
                            @php
                                $tipeAksi = $disposisi->tipe_aksi;
                                $badgeClass = 'bg-gray-100 text-gray-800'; // default

                                if ($tipeAksi === 'Kembalikan') {
                                    $badgeClass = 'bg-red-100 text-red-800';
                                } elseif ($tipeAksi === 'Teruskan') {
                                    $badgeClass = 'bg-green-100 text-green-800';
                                } elseif ($tipeAksi === 'Revisi') {
                                    $badgeClass = 'bg-yellow-100 text-yellow-800';
                                }
                            @endphp

                            <span class="text-xs font-medium px-2 py-1 rounded-full {{ $badgeClass }}">
                                {{ ucfirst($tipeAksi) }}
                            </span>
                        </td>
                    @endif
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
