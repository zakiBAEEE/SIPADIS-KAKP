<div
    class="relative flex flex-col w-full sm:max-h-[450px] overflow-scroll text-gray-700 bg-white shadow-md rounded-lg bg-clip-border sm:h-[450px] h-screen">

   <table class="w-full text-left table-auto text-slate-800 min-w-0 overflow-auto">
    <thead>
        <tr class="text-slate-500 border-b border-slate-300 bg-slate-50">
            <th class="p-3">Tgl. Kirim</th>
            <th class="p-3">Tujuan Disposisi</th>
            <th class="p-3">Perihal Surat</th>
            <th class="p-3">Catatan</th>
            <th class="p-3 text-center">Status di Penerima</th>
            <th class="p-3 text-center">Tipe Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($disposisis as $disposisi)
            <tr class="hover:bg-slate-50">
                <td class="p-3">
                    <p class="text-sm font-medium">
                        {{ optional($disposisi->created_at)->translatedFormat('d F Y H:i') ?? '-' }}
                    </p>
                </td>
                <td class="p-3">
                    <p class="text-sm font-medium">{{ optional($disposisi->penerima)->name ?? 'N/A' }}</p>
                    <p class="text-xs text-gray-500">
                        {{ optional(optional($disposisi->penerima)->divisi)->nama_divisi ?? '-' }}
                        ({{ optional(optional($disposisi->penerima)->role)->name ?? '-' }})
                    </p>
                </td>
                <td class="p-3">
                    <p class="text-sm font-medium">{{ optional($disposisi->suratMasuk)->nomor_surat ?? '-' }}</p>
                    <p class="text-sm">{{ optional($disposisi->suratMasuk)->perihal ?? '...' }}</p>
                </td>
                <td class="p-3">
                    <p class="text-sm">{{ $disposisi->catatan ?? '-' }}</p>
                </td>
                <td class="p-3 text-center">
                    @php
                        $statusColors = [
                            'Menunggu' => 'bg-yellow-100 text-yellow-800',
                            'Dilihat' => 'bg-blue-100 text-blue-800',
                            'Dikembalikan' => 'bg-red-100 text-red-800',
                            'Diteruskan' => 'bg-green-100 text-green-800',
                            'Selesai' => 'bg-emerald-100 text-emerald-800',
                        ];
                        $statusClass = $statusColors[$disposisi->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="{{ $statusClass }} px-2 py-1 text-xs rounded-full">
                        {{ $disposisi->status ?? '-' }}
                    </span>
                </td>
                <td class="p-3 text-center">
                    @php
                        $tipeAksi = $disposisi->tipe_aksi ?? '-';
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
            </tr>
        @empty
            <tr>
                <td colspan="6" class="p-3 text-center text-sm text-gray-500">
                    Menampilkan riwayat disposisi hari ini, gunakan filter untuk melihat data lainnya.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

</div>
