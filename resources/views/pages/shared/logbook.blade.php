@extends('layouts.super-admin-layout')

@section('content')
    <div class="bg-white min-h-screen rounded-xl shadow-lg p-6 overflow-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">
            Logbook Pegawai: {{ $user->name ?? '-' }}
        </h1>

        <!-- Dropdown Pegawai -->
        <form method="GET" class="mb-6">
            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Pegawai</label>
            <select name="user_id" id="user_id" onchange="this.form.submit()"
                class="w-full max-w-sm p-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">-- Pilih Pegawai --</option>
                @foreach ($users as $pegawai)
                    <option value="{{ $pegawai->id }}" {{ request('user_id') == $pegawai->id ? 'selected' : '' }}>
                        {{ $pegawai->name }} -
                        {{ $pegawai->role->name }}
                        @if (in_array($pegawai->role->name, ['Katimja', 'Staf']) && $pegawai->divisi)
                            ({{ $pegawai->divisi->nama_divisi }})
                        @endif
                    </option>
                @endforeach
            </select>
        </form>


        <!-- Tabs Material Tailwind Style -->
        <div class="flex bg-slate-100 p-1 relative rounded-lg mb-6" role="tablist">
            <div id="tab-indicator"
                class="absolute shadow-sm top-1 left-0.5 h-8 bg-white rounded-md transition-all duration-300 transform z-0 w-[140px]">
            </div>

            <button type="button"
                class="tab-link z-10 relative text-sm inline-block py-2 px-4 text-slate-800 transition-all duration-300"
                data-tab-target="tab-tertahan">📌 Surat Tertahan</button>

            @if (!$isStaff)
                <button type="button"
                    class="tab-link z-10 relative text-sm inline-block py-2 px-4 text-slate-800 transition-all duration-300"
                    data-tab-target="tab-riwayat">🕓 Riwayat Disposisi</button>
            @endif
        </div>

        <div class="tab-content-container">
            <!-- Tab: Surat Tertahan -->
            <div id="tab-tertahan" class="tab-content">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Surat Tertahan</h2>
                {{-- <div class="flex justify-center mb-7">
                    <div
                        class="p-4 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-700 text-white shadow-lg flex flex-col items-center justify-center w-1/3 ">
                        <div class="text-lg font-bold">Surat Tertahan</div>
                        <div class="text-3xl font-bold">{{ $suratTertahan->count() ?? 0 }}</div>
                    </div>
                </div> --}}

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-5 mb-7">
                    <div
                        class="p-4 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-700 text-white shadow-lg flex flex-col items-center justify-center">
                        <div class="text-lg font-bold">Umum</div>
                        <div class="text-3xl font-bold">
                            {{ isset($suratTertahanGroupedByKlasifikasi['Umum']) ? $suratTertahanGroupedByKlasifikasi['Umum']->count() : 0 }}
                        </div>
                    </div>
                    <div
                        class="p-4 rounded-xl bg-gradient-to-r from-orange-500 to-orange-700 text-white shadow-lg flex flex-col items-center justify-center">
                        <div class="text-lg font-bold">Pengaduan</div>
                        <div class="text-3xl font-bold">
                            {{ isset($suratTertahanGroupedByKlasifikasi['Pengaduan']) ? $suratTertahanGroupedByKlasifikasi['Pengaduan']->count() : 0 }}
                        </div>
                    </div>
                    <div
                        class="p-4 rounded-xl bg-gradient-to-r from-red-500 to-red-700 text-white shadow-lg flex flex-col items-center justify-center">
                        <div class="text-lg font-bold">Permintaan Informasi</div>
                        <div class="text-3xl font-bold">
                            {{ isset($suratTertahanGroupedByKlasifikasi['Permintaan Informasi']) ? $suratTertahanGroupedByKlasifikasi['Permintaan Informasi']->count() : 0 }}
                        </div>
                    </div>

                </div>


                @if ($suratTertahan->isNotEmpty())
                    {{-- <div class="overflow-x-auto">
                        <table class="min-w-full  text-slate-800">
                            <thead class="bg-slate-50 text-slate-600">
                                <tr>
                                    <th class="p-3 text-sm">No. Surat</th>
                                    <th class="p-3 text-sm">Perihal</th>
                                    <th class="p-3 text-sm">Tanggal</th>
                                    <th class="p-3 text-sm">Asal Instansi</th>
                                    <th class="p-3 text-sm">Klasifikasi Surat</th>
                                    <th class="p-3 text-sm">Sifat Surat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suratTertahan as $item)
                                    @php
                                        $surat = $isStaff ? $item : $item->suratMasuk;
                                    @endphp
                                    <tr class="hover:bg-slate-50 border-b">
                                        <td class="p-3 text-sm">{{ $surat->nomor_surat ?? '-' }}</td>
                                        <td class="p-3 text-sm">{{ $surat->perihal ?? '-' }}</td>
                                        <td class="p-3 text-sm">{{ $surat->tanggal_surat ?? '-' }}</td>
                                        <td class="p-3 text-sm">{{ $surat->asal_instansi ?? '-' }}</td>
                                        <td class="p-3 text-sm">
                                            {{ $surat->klasifikasi_surat ?? '-' }}
                                        </td>
                                        <td class="p-3 text-sm">
                                            {{ $surat->sifat ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> --}}
                    <div>

                        @foreach (['Umum', 'Pengaduan', 'Permintaan Informasi'] as $index => $sifat)
                            <h3 class="font-bold mb-2 text-slate-600 text-2xl mt-5">{{ $sifat }}
                            </h3>
                            <div class="mt-5">
                                @include('components.table.table', [
                                    'surats' => $suratTertahanGroupedByKlasifikasi[$sifat] ?? [],
                                ])
                            </div>
                        @endforeach

                    </div>
                @else
                    <p class="text-gray-600">Belum ada surat tertahan untuk pegawai ini.</p>
                @endif
            </div>

            <!-- Tab: Riwayat Disposisi -->
            @if (!$isStaff)
                <div id="tab-riwayat" class="tab-content hidden">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Riwayat Disposisi</h2>

                    @if ($logRiwayat->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-slate-800">
                                <thead class="bg-slate-50 text-slate-600">
                                    <tr>
                                        <th class="p-3 text-sm w-1/5">Tanggal</th>
                                        <th class="p-3 text-sm">Aktivitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($logRiwayat as $log)
                                        <tr class="hover:bg-slate-50 border-b">
                                            <td class="p-3 text-sm">
                                                {{ $log->created_at->format('d M Y, H:i') }}
                                            </td>
                                            <td class="p-3 text-sm leading-relaxed">
                                                @php
                                                    $pengirim = $log->pengirim->name ?? 'Pengguna tidak ditemukan';
                                                    $penerima = $log->penerima->name ?? 'Pengguna tidak ditemukan';
                                                    $nomorSurat =
                                                        $log->suratMasuk->nomor_surat ?? 'Nomor tidak tersedia';
                                                    $perihal = $log->suratMasuk->perihal ?? 'Perihal tidak tersedia';
                                                    $status = $log->status;
                                                @endphp

                                                @if ($status === 'Diteruskan')
                                                    {{ $pengirim }} meneruskan surat
                                                    <strong>"{{ $perihal }}"</strong>
                                                    ({{ $nomorSurat }})
                                                    kepada {{ $penerima }}.
                                                @elseif ($status === 'Dilihat')
                                                    {{ $pengirim }} telah membaca surat
                                                    <strong>"{{ $perihal }}"</strong>
                                                    ({{ $nomorSurat }}).
                                                @elseif ($status === 'Dikembalikan')
                                                    {{ $pengirim }} mengembalikan surat
                                                    <strong>"{{ $perihal }}"</strong>
                                                    ({{ $nomorSurat }}) kepada {{ $penerima }}.
                                                @elseif ($status === 'Menunggu')
                                                    Surat <strong>"{{ $perihal }}"</strong> ({{ $nomorSurat }})
                                                    sedang menunggu tindakan dari {{ $penerima }}.
                                                @else
                                                    Aktivitas tidak dikenali pada surat
                                                    <strong>"{{ $perihal }}"</strong>
                                                    ({{ $nomorSurat }}).
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="p-3 text-center text-sm text-slate-500">
                                                Tidak ada riwayat disposisi untuk surat ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    @else
                        <p class="text-gray-600">Belum ada riwayat disposisi untuk pegawai ini.</p>
                    @endif
                </div>
            @endif
        </div>

    </div>

    <!-- Tab Switching Script -->
    <script>
        const tabs = document.querySelectorAll('.tab-link');
        const contents = document.querySelectorAll('.tab-content');
        const indicator = document.getElementById('tab-indicator');

        function switchTab(targetId, tabElement) {
            contents.forEach(c => c.classList.add('hidden'));
            document.getElementById(targetId).classList.remove('hidden');

            tabs.forEach(t => t.classList.remove('font-bold'));
            tabElement.classList.add('font-bold');

            // Move indicator
            const tabRect = tabElement.getBoundingClientRect();
            const parentRect = tabElement.parentElement.getBoundingClientRect();
            indicator.style.transform = `translateX(${tabRect.left - parentRect.left}px)`;
            indicator.style.width = `${tabRect.width}px`;
            indicator.classList.remove('scale-x-0');
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                const target = tab.getAttribute('data-tab-target');
                switchTab(target, tab);
            });
        });

        // Activate default tab on load
        window.addEventListener('load', () => {
            const firstTab = document.querySelector('.tab-link');
            if (firstTab) {
                firstTab.click();
            }
        });
    </script>
@endsection
