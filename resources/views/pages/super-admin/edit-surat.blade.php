@extends('layouts.super-admin-layout')
@section('content')
    <div class="bg-white min-w-full h-full rounded-xl shadow-neutral-400 shadow-lg overflow-scroll p-4">
        <div class="flex flex-col gap-4">
            <div class="flex flex-row justify-between">
                <h4 class="font-sans text-xl font-bold antialiased md:text-2xl lg:text-3xl text-gray-600">Edit Surat
                </h4>
                {{-- @include('components.base.tombol-kembali') --}}
            </div>
            <hr class="w-full border-t border-gray-300 my-2" />
        </div>
        <div class="relative tab-group">
            <div class="mt-4 tab-content-container">
                <form action="{{ route('surat.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="tab1-group4" class="tab-content text-slate-800 block">
                        <div class="p-4">
                            <div class="flex flex-row gap-3">
                                <div class="mb-4 space-y-1.5 w-1/2">
                                    <div>
                                        <div class="relative w-full">
                                            @include('components.base.input-surat', [
                                                'label' => 'Nomor Surat',
                                                'placeholder' => 'Masukkan Nomor Surat',
                                                'name' => 'nomor_surat',
                                                'value' => $surat->nomor_surat,
                                            ])
                                        </div>
                                    </div>

                                </div>
                                <div class="mb-4 space-y-1.5 w-1/3">
                                    <div>
                                        <div class="relative w-full">
                                            @include('components.base.datepicker', [
                                                'label' => 'Tanggal Surat',
                                                'placeholder' => 'Pilih Tanggal Surat',
                                                'id' => 'tanggal_surat',
                                                'name' => 'tanggal_surat',
                                                'value' => $surat->tanggal_surat,
                                            ])
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4 space-y-1.5 w-1/3">
                                    <div>
                                        <div class="relative w-full">
                                            @include('components.base.datepicker', [
                                                'label' => 'Tanggal Terima',
                                                'placeholder' => 'Pilih Tanggal Terima',
                                                'id' => 'tanggal_terima',
                                                'name' => 'tanggal_terima',
                                                'value' => $surat->tanggal_terima,
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-row gap-3 items-center">
                                <div class="mb-4 space-y-1.5 w-1/2">
                                    <div>
                                        <div class="relative w-full">
                                            @include('components.base.input-surat', [
                                                'label' => 'Pengirim',
                                                'placeholder' => 'Masukkan Nomor Pengirim',
                                                'name' => 'pengirim',
                                                'value' => $surat->pengirim,
                                            ])
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4 space-y-1.5 w-1/3">
                                    <div>
                                        <div class="relative w-full">
                                            @include('components.base.dropdown', [
                                                'label' => 'Klasifikasi',
                                                'value' => ['Umum', 'Pengaduan', 'Permintaan Informasi'],
                                                'name' => 'klasifikasi_surat',
                                                'selected' => $surat->klasifikasi_surat ?? null,
                                            ])
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4 space-y-1.5 w-1/3">
                                    <div>
                                        <div class="relative w-full">
                                            @include('components.base.dropdown', [
                                                'label' => 'Sifat',
                                                'value' => ['Rahasia', 'Penting', 'Segera', 'Rutin'],
                                                'name' => 'sifat',
                                                'selected' => $surat->sifat ?? null,
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 space-y-1.5 w-1/3">
                                <div>
                                    <div class="relative w-full">
                                        @include('components.base.input-surat', [
                                            'label' => 'Perihal',
                                            'placeholder' => 'Masukkan Perihal',
                                            'name' => 'perihal',
                                            'value' => $surat->perihal,
                                        ])
                                    </div>
                                </div>
                            </div>
                            {{-- Preview Dokumen yang Sudah Diunggah --}}
                            @if ($surat->file_path)
                                <div class="mb-4">
                                    <label class="block font-sans text-sm text-slate-800 font-bold mb-2">
                                        Dokumen Saat Ini:
                                    </label>

                                    @if (Str::endsWith($surat->file_path, ['.pdf']))
                                        <iframe src="{{ asset('storage/' . $surat->file_path) }}"
                                            class="w-full h-[400px] border rounded" frameborder="0">
                                        </iframe>
                                    @else
                                        <img src="{{ asset('storage/' . $surat->file_path) }}" alt="Preview Dokumen"
                                            class="max-w-full h-auto border rounded">
                                    @endif
                                </div>
                            @endif
                            @include('components.base.file-picker', [
                                'label' => 'Upload Ulang Dokumen (Opsional)',
                                'name' => 'file_path',
                            ])
                            <div class=" px-4 pb-4 flex justify-end gap-2">
                                @include('components.base.tombol-simpan-surat')
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
