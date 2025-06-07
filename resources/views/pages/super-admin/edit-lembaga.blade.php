@extends('layouts.super-admin-layout')

@section('content')
    <div
        class="bg-white min-w-full h-full rounded-xl shadow-neutral-400 shadow-lg overflow-scroll p-4 flex flex-col gap-y-6">
        <div class="flex flex-col p-4">
            <div class="flex flex-row justify-between items-end">
                <div>
                    <h4 class="font-sans text-xl font-bold antialiased md:text-2xl lg:text-2xl text-gray-600">Data Lembaga
                    </h4>
                    <h6 class="font-sans text-base font-bold antialiased md:text-lg lg:text-lg text-gray-600">LLDIKTI Wilayah
                        2
                    </h6>
                </div>
                <div class="h-[30px]">
                    <a href="{{ route('lembaga.index') }}"
                        class="inline-flex border font-medium font-sans text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md px-1 shadow-sm hover:shadow-md bg-transparent border-slate-800 text-slate-800 flex-row justify-center items-center gap-1"
                        data-toggle="tooltip" data-placement="left-start" data-title="Kembali"
                        data-tooltip-class="bg-slate-950 text-white text-xs rounded-md py-1 px-2 shadow-md z-50">
                        @include('components.base.ikon-kembali')
                    </a>
                </div>
            </div>
            <hr class="w-full border-t border-gray-300 my-1" />
            <form action="{{ route('lembaga.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col gap-7">
                    <div class="flex flex-col">
                        <div class="flex flex-row gap-x-5">
                            <div class="flex flex-col w-5/6 gap-3">
                                @include('components.base.input-surat', [
                                    'label' => 'Nama Kementrian',
                                    'placeholder' => 'Masukkan Nama Kementrian',
                                    'name' => 'nama_kementerian',
                                    'value' => old('nama_kementerian', $lembaga->nama_kementerian ?? ''),
                                ])
                                @include('components.base.input-surat', [
                                    'label' => 'Nama Lembaga',
                                    'placeholder' => 'Masukkan Nama Lembaga',
                                    'name' => 'nama_lembaga',
                                    'value' => old('nama_lembaga', $lembaga->nama_lembaga ?? ''),
                                ])
                                <div class="flex flex-row w-full gap-3">
                                    <div class="flex flex-col w-1/2 gap-3">
                                        @include('components.base.input-surat', [
                                            'label' => 'Alamat',
                                            'placeholder' => 'Masukkan Alamat',
                                            'name' => 'alamat',
                                            'value' => old('alamat', $lembaga->alamat ?? ''),
                                        ])
                                    </div>
                                    <div class="flex flex-col w-1/2 gap-3">
                                        @include('components.base.input-surat', [
                                            'label' => 'Telepon',
                                            'placeholder' => 'Masukkan Telepon',
                                            'name' => 'telepon',
                                            'value' => old('telepon', $lembaga->telepon ?? ''),
                                        ])
                                        @include('components.base.input-surat', [
                                            'label' => 'Website',
                                            'placeholder' => 'Masukkan Alamat Website',
                                            'name' => 'website',
                                            'value' => old('website', $lembaga->website ?? ''),
                                        ])
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-3 items-center">
                                @if ($lembaga->logo)
                                    <div class="mb-4">
                                        <label
                                            class="block font-sans text-sm text-slate-800 font-bold mb-2">
                                            Logo Saat Ini:
                                        </label>
                                        <img src="{{ asset('storage/' . $lembaga->logo) }}" alt="Preview Dokumen"
                                            class="max-w-full h-auto border rounded" width="100px" height="50px">
                                    </div>
                                @endif
                                <div class="w-full h-full">
                                    @include('components.base.file-picker', [
                                        'label' => 'Upload Logo Lembaga',
                                        'file' => $lembaga->logo ?? '',
                                        'name' => 'logo',
                                    ])
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="flex flex-col gap-7">
                        <div class="flex flex-row gap-3 w-full">
                            <div class="w-1/3">
                                @include('components.base.input-surat', [
                                    'label' => 'Tahun',
                                    'placeholder' => 'Masukkan Tahun',
                                    'name' => 'tahun',
                                    'value' => old('tahun', $lembaga->tahun ?? ''),
                                ])
                            </div>
                            <div class="w-1/3">
                                @include('components.base.input-surat', [
                                    'label' => 'Kota',
                                    'placeholder' => 'Masukkan Nama Kota',
                                    'name' => 'kota',
                                    'value' => old('kota', $lembaga->kota ?? ''),
                                ])
                            </div>
                            <div class="w-1/3">
                                @include('components.base.input-surat', [
                                    'label' => 'Provinsi',
                                    'placeholder' => 'Masukkan Nama Provinsi',
                                    'name' => 'provinsi',
                                    'value' => old('provinsi', $lembaga->provinsi ?? ''),
                                ])
                            </div>
                        </div>
                        <div class="flex flex-row gap-3">
                            <div class="w-1/3">
                                @include('components.base.input-surat', [
                                    'label' => 'Kepala Kantor',
                                    'placeholder' => 'Masukkan Nama Kepala Kantor',
                                    'name' => 'kepala_kantor',
                                    'value' => old('kepala_kantor', $lembaga->kepala_kantor ?? ''),
                                ])
                            </div>
                            <div class="w-1/3">
                                @include('components.base.input-surat', [
                                    'label' => 'NIP',
                                    'placeholder' => 'Masukkan NIP Kepala Kantor',
                                    'name' => 'nip_kepala_kantor',
                                    'value' => old('nip_kepala_kantor', $lembaga->nip_kepala_kantor ?? ''),
                                ])
                            </div>
                            <div class="w-1/3">
                                @include('components.base.input-surat', [
                                    'label' => 'Jabatan',
                                    'placeholder' => 'Masukkan Jabatan',
                                    'name' => 'jabatan',
                                    'value' => old('jabatan', $lembaga->jabatan ?? ''),
                                ])
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-7 flex-row gap-2">
                    @include('components.base.tombol-simpan-surat')
                </div>
            </form>

        </div>
    </div>
@endsection
