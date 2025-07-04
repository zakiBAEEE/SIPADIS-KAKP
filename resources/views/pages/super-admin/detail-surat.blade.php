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

                            {{-- 2. Tampilkan tombol aksi HANYA JIKA ada disposisi aktif DAN 
                   pengguna yang login adalah penerima disposisi aktif tersebut --}}
                            @if ($activeDisposisi && $activeDisposisi->ke_user_id === auth()->id())
                                {{-- Tombol untuk memicu modal "Tambah/Teruskan Disposisi" --}}
                                @if (!in_array(auth()->user()->role->name, ['Staf', 'Admin']))
                                    @include('components.layout.modal-tambah-disposisi')
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
