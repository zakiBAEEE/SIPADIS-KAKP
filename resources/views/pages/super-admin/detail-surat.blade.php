@extends('layouts.super-admin-layout')


@section('content')
    <div class="bg-white min-w-full h-full rounded-xl shadow-neutral-400 shadow-lg overflow-scroll p-4">
        <div class="flex flex-col gap-4">
            <div class="flex flex-row justify-between">
                <h4 class="font-sans text-xl font-bold antialiased md:text-2xl lg:text-3xl text-gray-600">Detail Surat</h4>
            </div>
            <hr class="w-full border-t border-gray-300 my-2" />
        </div>
        <div class="relative tab-group">
            <div class="flex border-b border-slate-200 relative justify-between" role="tablist">
                <div>
                    <div
                        class="absolute bottom-0 h-0.5 bg-slate-800 transition-transform duration-300 transform scale-x-0 translate-x-0 tab-indicator">
                    </div>

                    <a href="#"
                        class="tab-link text-sm active inline-block py-2 px-4 text-slate-800 transition-colors duration-300 mr-1"
                        data-tab-target="tab1-group4">
                        Data
                    </a>
                    <a href="#"
                        class="tab-link text-sm inline-block py-2 px-4 text-slate-800 transition-colors duration-300 mr-1"
                        data-tab-target="tab2-group4">
                        Disposisi
                    </a>
                </div>
            </div>
            <div class="mt-4 tab-content-container">
                <div id="tab1-group4" class="tab-content text-slate-800 block">
                    @php
                        $user = Auth::user();
                        $isAdmin = $user->role->name === 'Admin';

                        $disposisiTerakhir = $surat->disposisis()->latest()->first();
                        $belumPernahDidisposisikan = $disposisiTerakhir === null;
                        $terakhirKembalikan = $disposisiTerakhir && $disposisiTerakhir->tipe_aksi === 'Kembalikan';
                    @endphp

                    @if ($isAdmin && ($belumPernahDidisposisikan || $terakhirKembalikan))
                        <div class="flex justify-end">
                            <a href="{{ route('surat.edit', ['surat' => $surat->id]) }}"
                                class="inline-flex items-center gap-1 rounded-md border border-orange-400 bg-orange-100 px-2 py-1 text-sm font-medium text-orange-800 hover:bg-orange-200 hover:shadow transition duration-150 ease-in-out">
                                @include('components.base.ikon-edit')
                                <span>Edit Surat</span>
                            </a>
                        </div>
                    @endif

                    <div class="p-4">
                        <div class="flex flex-row gap-3">
                            <div class="mb-4 space-y-1.5 w-1/2">
                                <div>
                                    <label for="email" class="font-sans  text-sm text-slate-800 font-bold mb-2"> Nomor
                                        Surat</label>
                                    <div class="relative w-full">
                                        <h6 class="font-sans text-base font-light antialiased md:text-lg lg:text-xl"
                                            id="modal_nomor_surat">
                                            {{ $surat->nomor_surat }} </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 space-y-1.5 w-1/3">
                                <div>
                                    <label for="email" class="font-sans  text-sm text-slate-800 font-bold mb-2"> Tanggal
                                        Surat</label>
                                    <div class="relative w-full">
                                        <h6 class="font-sans text-base font-light antialiased md:text-lg lg:text-xl"
                                            id="modal_tgl_surat">
                                            {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 space-y-1.5 w-1/3">
                                <div>
                                    <label for="email" class="font-sans  text-sm text-slate-800 font-bold mb-2"> Tanggal
                                        Terima</label>
                                    <div class="relative w-full">
                                        <h6 class="font-sans text-base font-light antialiased md:text-lg lg:text-xl"
                                            id="modal_tgl_terima">
                                            {{ \Carbon\Carbon::parse($surat->created_at)->translatedFormat('d F Y') }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row gap-3 items-center">
                            <div class="mb-4 space-y-1.5 w-1/2">
                                <div>
                                    <label for="email" class="font-sans  text-sm text-slate-800 font-bold mb-2">
                                        Pengirim</label>
                                    <div class="relative w-full">
                                        <h6 class="font-sans text-base font-light antialiased md:text-lg lg:text-xl"
                                            id="modal_pengirim">
                                            {{ $surat->pengirim }} </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 space-y-1.5 w-1/3">
                                <div>
                                    <label for="email" class="font-sans  text-sm text-slate-800 font-bold mb-2">
                                        Klasifikasi</label>
                                    <div class="relative w-full">
                                        <h6 class="font-sans text-base font-light antialiased md:text-lg lg:text-xl"
                                            id="modal_klasifikasi">
                                            {{ $surat->klasifikasi_surat }} </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 space-y-1.5 w-1/3">
                                <div>
                                    <label for="email" class="font-sans  text-sm text-slate-800 font-bold mb-2">
                                        Sifat</label>
                                    <div class="relative w-full">
                                        <h6 class="font-sans text-base font-light antialiased md:text-lg lg:text-xl"
                                            id="modal_sifat">
                                            {{ $surat->sifat }} </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 space-y-1.5 w-1/3">
                            <div>
                                <label for="email" class="font-sans  text-sm text-slate-800 font-bold mb-2">
                                    Perihal</label>
                                <div class="relative w-full">
                                    <h6 class="font-sans text-base font-light antialiased md:text-lg lg:text-xl"
                                        id="modal_perihal">
                                        {{ $surat->perihal }} </h6>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <p class="font-sans  text-sm text-slate-800 font-bold mb-2">Preview Dokumen:</p>
                            @if ($surat->file_path)
                                <div class="mt-4">
                                    @if (Str::endsWith($surat->file_path, '.pdf'))
                                        <iframe src="{{ asset('storage/' . $surat->file_path) }}" class="w-full h-[500px]"
                                            frameborder="0"></iframe>
                                    @else
                                        <img src="{{ asset('storage/' . $surat->file_path) }}" alt="Preview Dokumen"
                                            class="max-w-full h-auto border rounded">
                                    @endif
                                </div>
                            @else
                                <p class="text-sm text-slate-600">Tidak ada dokumen terlampir.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div id="tab2-group4" class="tab-content text-slate-800 hidden">

                    <div class="flex justify-end">
                        <div class="flex flex-row gap-2">
                            @if (in_array(auth()->user()->role->name, ['Admin']))
                                @include('components.base.tombol-print-disposisi', ['surat' => $surat])
                            @endif

                            @php
                                // 1. Cari disposisi terakhir yang statusnya masih aktif ('Terkirim' atau 'Dilihat')
                                $activeDisposisi = $surat->disposisis
                                    ->whereIn('status', ['Menunggu', 'Dilihat'])
                                    ->sortByDesc('created_at')
                                    ->first();
                            @endphp

                            @if ($activeDisposisi && $activeDisposisi->ke_user_id === auth()->id())
                                @if (!in_array(auth()->user()->role->name, ['Staf', 'Admin']))
                                    @include('components.layout.modal-tambah-disposisi')
                                @endif

                                @if ($isAdmin && ($belumPernahDidisposisikan || $terakhirKembalikan))
                                    <form method="POST" action="{{ route('surat.kirimUlangKeKepala', $surat->id) }}"
                                        onsubmit="return confirm('Anda yakin ingin mengirim ulang surat ini setelah direvisi?');">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 bg-green-600 text-white rounded-md text-xs font-semibold hover:bg-green-700 flex flex-row items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                            </svg>
                                            <p>Kirim ke Kepala</p>
                                        </button>
                                    </form>
                                @endif

                                {{-- Tombol untuk mengembalikan disposisi (jika sudah dibuat) --}}
                                @if (!in_array(auth()->user()->role->name, ['Staf', 'Admin']))
                                    @include('components.layout.modal-kembalikan-disposisi', [
                                        'disposisi' => $activeDisposisi,
                                    ])
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
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
