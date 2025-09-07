@extends('layouts.main-layout')


@section('content')
    @if (session('success'))
        <div class="js-dismissable-alert fixed top-6 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md flex items-center justify-between rounded-lg bg-green-100 px-6 py-5 text-base text-green-700 shadow-lg transition-opacity duration-300"
            role="alert">
            <span>{{ session('success') }}</span>
            <button type="button" class="js-close-alert text-green-700 hover:text-green-900">
                &times;
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="js-dismissable-alert fixed top-6 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md flex items-center justify-between rounded-lg bg-red-100 px-6 py-5 text-base text-red-700 shadow-lg transition-opacity duration-300"
            role="alert">
            <span>{{ session('error') }}</span>
            <button type="button" class="js-close-alert text-red-700 hover:text-red-900">
                &times;
            </button>
        </div>
    @endif

    <div class="bg-white min-w-full h-full rounded-xl shadow-neutral-400 shadow-lg overflow-scroll p-4">
        <div class="flex flex-col gap-4">
            <div class="flex flex-row justify-between items-center">
                <h4 class="font-sans text-xl font-bold antialiased md:text-2xl lg:text-3xl text-gray-600">
                    Detail Surat
                </h4>

                {{-- Badge Status --}}
                @php
                    $status = strtolower($surat->status);
                    $badgeClass = match ($status) {
                        'diproses' => 'bg-yellow-100 text-yellow-800',
                        'ditindaklanjuti' => 'bg-blue-100 text-blue-800',
                        'selesai' => 'bg-green-100 text-green-800',
                        'dikembalikan' => 'bg-red-100 text-red-800',
                        'ditolak' => 'bg-gray-200 text-gray-800',
                        default => 'bg-slate-100 text-slate-700',
                    };
                @endphp

                <span class="px-3 py-1 rounded-full text-sm font-medium capitalize {{ $badgeClass }}">
                    {{ $surat->status }}
                </span>
            </div>

            <hr class="w-full border-t border-gray-300 my-2" />
        </div>
        <div class="relative tab-group">
            <div class="mt-4 ">

                <div class="flex flex-row justify-end gap-2">
                    @php
                        $user = Auth::user();
                        $isAdmin = $user->role->name === 'Admin';

                        $disposisiTerakhir = $surat->disposisis()->latest()->first();
                        $belumPernahDidisposisikan = !$surat->disposisis()->exists();
                        $terakhirKembalikan = $disposisiTerakhir && $disposisiTerakhir->tipe_aksi === 'Kembalikan';
                    @endphp

                    @if ($isAdmin && ($belumPernahDidisposisikan || $terakhirKembalikan) && $surat->status != 'ditolak')
                        <a href="{{ route('surat.edit', ['surat' => $surat->id]) }}"
                            class="inline-flex items-center gap-1 rounded-md border border-orange-400 bg-orange-100 px-2 py-1 text-sm font-medium text-orange-800 hover:bg-orange-200 hover:shadow transition duration-150 ease-in-out">
                            @include('components.base.ikon-edit')
                            <span>Edit Surat</span>
                        </a>
                    @endif


                    <div class="flex flex-row gap-2">
                        @php
                            // 1. Cari disposisi terakhir yang statusnya masih aktif ('Terkirim' atau 'Dilihat')
                            $activeDisposisi = $surat->disposisis
                                ->whereIn('status', ['Menunggu', 'Dilihat'])
                                ->sortByDesc('created_at')
                                ->first();
                        @endphp



                        @if (($activeDisposisi && $activeDisposisi->ke_user_id === auth()->id()) || $belumPernahDidisposisikan)

                            {{-- Khusus untuk Admin --}}
                            @if ($surat->status != 'ditolak')
                                @if ($isAdmin)
                                    @if ($belumPernahDidisposisikan)
                                        @include('components.modal.modal-kirimKeKepala')
                                    @else
                                        @include('components.modal.modal-tambah-disposisi')
                                    @endif
                                @else
                                    {{-- Non-Admin --}}
                                    @if (!in_array(auth()->user()->role->name, ['Staf', 'Katimja']))
                                        @include('components.modal.modal-tambah-disposisi')
                                    @endif

                                    @if (in_array(auth()->user()->role->name, ['Katimja']))
                                        @include('components.modal.modal-kirimKeStaf')
                                    @endif
                                @endif
                            @endif

                            {{-- Tombol kembalikan disposisi untuk selain Staf & Admin --}}
                            @if (!in_array(auth()->user()->role->name, ['Staf', 'Admin']))
                                @include('components.modal.modal-kembalikan-disposisi', [
                                    'disposisi' => $activeDisposisi,
                                ])
                            @endif
                        @endif


                        @if (auth()->user()->role->name === 'Staf' || auth()->user()->role->name === 'Admin')
                            @php
                                $status = strtolower($surat->status);
                                $role = auth()->user()->role->name;
                            @endphp

                            <div class="flex flex-row gap-1.5">
                                {{-- Jika status DIPROSES: Tampilkan tombol tindak lanjut dan kembalikan (khusus staf) --}}
                                @if ($status === 'diproses' && $role === 'Staf')
                                    <form action="{{ route('surat.tandaiDitindaklanjuti', $surat->id) }}" method="POST"
                                        onsubmit="return confirm('PERINGATAN!\n\nSetelah surat ditindaklanjuti, proses tidak dapat dibatalkan dan surat tidak dapat dikembalikan ke status sebelumnya.\n\nApakah Anda yakin ingin melanjutkan?')">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 rounded-md text-sm font-semibold bg-blue-100 text-blue-700 hover:bg-blue-200">
                                            Tindak Lanjut
                                        </button>
                                    </form>


                                    {{-- Modal Kembalikan --}}
                                    @include('components.modal.modal-kembalikan-disposisiStaf', [
                                        'disposisi' => $activeDisposisi,
                                    ])
                                @endif

                                {{-- Jika status DITINDAKLANJUTI: Tampilkan tombol selesai (khusus staf) --}}
                                @if ($status === 'ditindaklanjuti' && $role === 'Staf')
                                    <form action="{{ route('surat.tandaiSelesai', $surat->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menandai surat ini sebagai Selesai?')">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 rounded-md text-sm font-semibold bg-green-100 text-green-700 hover:bg-green-200">
                                            Tandai Selesai
                                        </button>
                                    </form>
                                @endif

                                {{-- Tombol ditolak: --}}
                                @if (($status === 'ditindaklanjuti' && $role === 'Staf') || ($role === 'Admin' && $surat->status != 'ditolak'))
                                    @include('components.modal.modal-tolak-surat')
                                @endif
                            </div>
                        @endif

                    </div>
                </div>


                <div class="p-4">
                    <div class="flex flex-col gap-2">
                        <div class="flex flex-row items-center justify-start gap-3 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24"
                                fill="none">
                                <path stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5h10M11 9h5" />
                                <rect width="4" height="4" x="3" y="5" stroke="#000000" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" rx="1" />
                                <path stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 15h10m-10 4h5" />
                                <rect width="4" height="4" x="3" y="15" stroke="#000000" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" rx="1" />
                            </svg>
                            <h2 class="text-2xl font-bold text-slate-800">Data Surat</h2>
                        </div>

                        @include('components.table.table-detail-surat', [
                            'surat' => $surat,
                        ])
                    </div>

                    <div class="flex flex-col gap-2 mt-7">
                        <div class="flex flex-row items-center justify-start gap-3 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" width="30px" height="30px"
                                viewBox="-8 0 32 32" version="1.1">

                                <title>attachment</title>
                                <desc>Created with Sketch Beta.</desc>
                                <defs>

                                </defs>
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                                    sketch:type="MSPage">
                                    <g id="Icon-Set" sketch:type="MSLayerGroup"
                                        transform="translate(-212.000000, -151.000000)" fill="#000000">
                                        <path
                                            d="M226,155 L226,175 C226,178.313 223.313,181 220,181 C216.687,181 214,178.313 214,175 L214,157 C214,154.791 215.791,153 218,153 C220.209,153 222,154.791 222,157 L222,175 C222,176.104 221.104,177 220,177 C218.896,177 218,176.104 218,175 L218,159 L216,159 L216,175 C216,177.209 217.791,179 220,179 C222.209,179 224,177.209 224,175 L224,157 C224,153.687 221.313,151 218,151 C214.687,151 212,153.687 212,157 L212,176 C212.493,179.945 215.921,183 220,183 C224.079,183 227.507,179.945 228,176 L228,155 L226,155"
                                            id="attachment" sketch:type="MSShapeGroup">

                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <h2 class="text-2xl font-bold text-slate-800">Lampiran Surat</h2>
                        </div>
                        <div class="text-center">
                            <button data-toggle="collapse" data-target="#collapseButton" aria-expanded="false"
                                aria-controls="collapseButton"
                                class="inline-flex items-center justify-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-2 px-4 shadow-sm hover:shadow-md bg-slate-800 border-slate-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">Lampiran
                                File</button>
                            <div class="overflow-hidden transition-[max-height] duration-300 ease-in-out max-h-0 mt-1"
                                id="collapseButton">

                                <div class="space-y-1.5">
                                    <p class="font-sans text-sm text-slate-800 font-bold mb-2">Preview Dokumen:</p>
                                    @if ($surat->file_path)
                                        <div class="mt-4 w-full">
                                            @if (Str::endsWith($surat->file_path, '.pdf'))
                                                <iframe src="{{ asset('storage/' . $surat->file_path) }}"
                                                    class="w-full h-[500px]" frameborder="0"></iframe>
                                            @else
                                                <div class="flex flex-col items-start gap-2 mt-4 w-full">
                                                    <a href="{{ asset('storage/' . $surat->file_path) }}" download
                                                        class="px-2 py-2 text-sm bg-slate-700 text-white rounded hover:bg-slate-800 transition">
                                                        Download Gambar
                                                    </a>
                                                    <img src="{{ asset('storage/' . $surat->file_path) }}"
                                                        alt="Preview Dokumen" class="max-w-full h-auto border rounded">
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-sm text-slate-600">Tidak ada dokumen terlampir.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>



                </div>


                <div x-data="{ tab: 'timeline' }" class="p-4">
                    <div class="flex flex-row items-center justify-start gap-3 mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="4" cy="12" r="2" stroke="currentColor" stroke-width="2" />
                            <circle cx="12" cy="12" r="2" stroke="currentColor" stroke-width="2" />
                            <circle cx="20" cy="12" r="2" stroke="currentColor" stroke-width="2" />
                            <line x1="6" y1="12" x2="10" y2="12" stroke="currentColor"
                                stroke-width="2" />
                            <line x1="14" y1="12" x2="18" y2="12" stroke="currentColor"
                                stroke-width="2" />
                        </svg>

                        <h2 class="text-2xl font-bold text-slate-800">Progres Disposisi</h2>
                    </div>


                    {{-- Tombol Tab --}}
                    <div class="flex space-x-2 mb-4">
                        <button class="px-4 py-2 rounded font-medium text-sm"
                            :class="tab === 'timeline' ? 'bg-slate-700 text-white' : 'bg-slate-100 text-slate-700'"
                            @click="tab = 'timeline'">
                            Timeline
                        </button>
                        <button class="px-4 py-2 rounded font-medium text-sm"
                            :class="tab === 'table' ? 'bg-slate-700 text-white' : 'bg-slate-100 text-slate-700'"
                            @click="tab = 'table'">
                            Tabel
                        </button>
                    </div>

                    {{-- Konten Timeline --}}
                    <div x-show="tab === 'timeline'" x-transition class="flex justify-center overflow-auto">
                        @include('components.layout.timeline-disposisi', [
                            'disposisis' => $cleanTimeline,
                        ])
                    </div>

                    {{-- Konten Tabel --}}

                    <div x-show="tab === 'table'" x-transition>
                        @include('components.table.table-disposisi', [
                            'disposisis' => $surat->disposisis,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
@endpush
