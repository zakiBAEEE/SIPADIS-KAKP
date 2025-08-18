@extends('layouts.super-admin-layout')

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
            <div class=" tab-content-container">
                <form action="{{ route('surat.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div id="tab1-group4" class="tab-content text-slate-800 block">
                        <div class="p-4">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <div class="mb-4 space-y-1.5 sm:w-1/2 w-full">
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
                                <div class="flex flex-col sm:flex-row w-full gap-3 ">
                                    <div class="mb-4 space-y-1.5 sm:w-1/2 w-full">
                                        <div class="w-full">
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
                                    <div class="mb-4 space-y-1.5 sm:w-1/2 w-full">
                                        <div class="w-full">
                                            <div class="relative w-full">
                                                @include('components.base.datepicker', [
                                                    'label' => 'Tanggal Terima',
                                                    'placeholder' => 'Pilih Tanggal Terima',
                                                    'id' => 'created_at',
                                                    'name' => 'created_at',
                                                    'value' => $surat->created_at,
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex md:flex-row gap-3 flex-col">
                                <div class="mb-4 space-y-1.5 md:w-1/2 w-full">
                                    @include('components.base.input-surat', [
                                        'label' => 'Asal Instansi',
                                        'placeholder' => 'Masukkan Asal Instansi Surat',
                                        'name' => 'asal_instansi',
                                        'value' => $surat->asal_instansi,
                                    ])
                                </div>
                                <div class="mb-4 space-y-1.5  md:w-1/2 w-full">
                                    @include('components.base.input-email', [
                                        'label' => 'Email Pengirim',
                                        'placeholder' => 'Masukkan Email Pengirim',
                                        'name' => 'email_pengirim',
                                        'value' => $surat->email_pengirim,
                                    ])
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-3 items-center">
                                <div class="mb-4 space-y-1.5 sm:w-1/2 w-full">
                                    <div class="w-full">
                                        <div class="relative w-full">
                                            @include('components.base.input-surat', [
                                                'label' => 'Pengirim',
                                                'placeholder' => 'Masukkan Nama Pengirim',
                                                'name' => 'pengirim',
                                                'value' => $surat->pengirim,
                                            ])
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row w-full">
                                    <div class="mb-4 space-y-1.5 sm:w-1/2 w-full">
                                        <div class="w-full">
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
                                    <div class="mb-4 space-y-1.5 sm:w-1/2 w-full">
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
                            </div>
                            <div class="mb-4 space-y-1.5 w-full">
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
                            <div class="px-4">
                                @include('components.base.file-picker', [
                                    'label' => 'Upload Surat',
                                    'name' => 'file_path',
                                ])
                                <p class="mt-2 text-sm text-gray-500">* Hanya file bertipe <span
                                        class="font-medium text-gray-700">gambar (jpg, jpeg, png)</span> dan <span
                                        class="font-medium text-gray-700">PDF</span> yang diperbolehkan.</p>
                                <div class="mt-2">
                                    @error('file_path')
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
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
