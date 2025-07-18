@extends('layouts.super-admin-layout')


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
            <div class="flex flex-row justify-between">
                <h4 class="font-sans text-xl font-bold antialiased md:text-2xl lg:text-3xl text-gray-600">Detail Surat</h4>
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

                    @if ($isAdmin && ($belumPernahDidisposisikan || $terakhirKembalikan))
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
                            @if (!in_array(auth()->user()->role->name, ['Staf', 'Admin', 'Katimja']))
                                @include('components.layout.modal-tambah-disposisi')
                            @endif

                            @if (in_array(auth()->user()->role->name, ['Katimja']))
                                @include('components.layout.modal-kirimKeStaf')
                            @endif


                            @if ($isAdmin && ($belumPernahDidisposisikan || $terakhirKembalikan))
                                @include('components.layout.modal-kirimKeKepala')
                            @endif

                            {{-- Tombol untuk mengembalikan disposisi (jika sudah dibuat) --}}
                            @if (!in_array(auth()->user()->role->name, ['Staf', 'Admin']))
                                @include('components.layout.modal-kembalikan-disposisi', [
                                    'disposisi' => $activeDisposisi,
                                ])
                            @endif
                        @endif

                        @if (auth()->user()->role->name === 'Staf')
                            <div class="flex flex-row gap-1.5">
                                @php
                                    $isSelesai = strtolower($surat->status) === 'selesai'; // pakai strtolower untuk jaga-jaga
                                @endphp

                                <form action="{{ route('surat.toggleStatus', $surat->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ubah status surat ini?')">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 rounded-md text-sm font-semibold
                {{ $isSelesai ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                        {{ $isSelesai ? 'Tandai Diproses' : 'Tandai Selesai' }}
                                    </button>
                                </form>
                            </div>

                            @unless ($isSelesai)
                                @include('components.layout.modal-kembalikan-disposisiStaf', [
                                    'disposisi' => $activeDisposisi,
                                ])
                            @endunless
                        @endif

                    </div>

                </div>


                <div class="p-4">
                    @include('components.table.table-detail-surat', [
                        'surat' => $surat,
                    ])
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
                                    <div class="mt-4">
                                        @if (Str::endsWith($surat->file_path, '.pdf'))
                                            <iframe src="{{ asset('storage/' . $surat->file_path) }}"
                                                class="w-full h-[500px]" frameborder="0"></iframe>
                                        @else
                                            <div class="flex flex-col items-start gap-2 mt-4">
                                                <a href="{{ asset('storage/' . $surat->file_path) }}" download
                                                    class="px-2 py-2 text-sm bg-slate-700 text-white rounded hover:bg-slate-800 transition">
                                                    Download Gambar
                                                </a>
                                                <img src="{{ asset('storage/' . $surat->file_path) }}" alt="Preview Dokumen"
                                                    class="max-w-full h-auto border rounded">
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


                <div x-data="{ tab: 'timeline' }" class="p-4">
                    <h2 class="text-xl font-semibold text-slate-800 mb-4">Progres Disposisi</h2>

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
                    <div x-show="tab === 'timeline'" x-transition>
                        @include('components.layout.timeline-disposisi', [
                            'disposisis' => $surat->disposisis,
                        ])
                    </div>

                    {{-- Konten Tabel --}}

                    <div x-show="tab === 'table'" x-transition>
                        <div class="flex flex-row justify-end mb-3">
                            @if (in_array(auth()->user()->role->name, ['Admin']))
                                @include('components.base.tombol-print-disposisi', ['surat' => $surat])
                            @endif

                        </div>
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
