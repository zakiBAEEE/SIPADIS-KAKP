@extends('layouts.super-admin-layout')

@section('content')
    {{-- @dd($lembaga) --}}
    <div
        class="bg-white min-w-full h-full rounded-xl shadow-neutral-400 shadow-lg overflow-scroll p-4 flex flex-col gap-y-6">
        <div class="flex flex-col p-4">
            <div class="flex flex-row justify-between items-end">
                <div>
                    <h4 class="font-sans text-xl font-bold antialiased md:text-2xl lg:text-2xl text-gray-600">Data Lembaga
                    </h4>
                    <h6 class="font-sans text-base font-bold antialiased md:text-lg lg:text-lg text-gray-600">LLDIKTI Wilayah
                        2</h6>
                </div>
                <div class="h-[30px]">
                    <a href="{{ route('lembaga.edit') }}"
                        class="flex border font-medium font-sans text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md px-1 shadow-sm hover:shadow-md border-orange-400 text-slate-800 bg-orange-300 flex-row justify-center items-center gap-1 cursor-pointer h-full">
                        @include('components.base.ikon-edit') Edit
                    </a>
                </div>
            </div>
            <hr class="w-full border-t border-gray-300 my-1" />
            <div class="flex flex-col gap-5">
                <div class="flex flex-col">
                    <div class="flex flex-row gap-x-5">
                        <div class="flex flex-col w-5/6 gap-3">
                            @include('components.base.input-display', [
                                'label' => 'Nama Kementrian',
                                'value' => $lembaga->nama_kementerian,
                            ])
                            @include('components.base.input-display', [
                                'label' => 'Nama Lembaga',
                                'value' => $lembaga->nama_lembaga,
                            ])
                            <div class="flex flex-row w-full gap-3">
                                <div class="flex flex-col w-1/2 gap-3">
                                    @include('components.base.input-display', [
                                        'label' => 'Alamat',
                                        'value' => $lembaga->alamat,
                                    ])
                                </div>
                                <div class="flex flex-col w-1/2 gap-3">
                                    @include('components.base.input-display', [
                                        'label' => 'Telepon',
                                        'value' => $lembaga->telepon,
                                    ])
                                    @include('components.base.input-display', [
                                        'label' => 'Website',
                                        'value' => $lembaga->website ?? '-',
                                    ])
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block font-sans text-sm text-slate-800 font-bold mb-2">
                                Logo Saat Ini:
                            </label>
                            <img src="{{ asset('storage/' . $lembaga->logo) }}" alt="Preview Dokumen"
                                class="max-w-full h-auto border rounded" width="100px" height="50px">
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <div class="flex flex-row gap-3 w-full">
                        <div class="w-1/3">
                            @include('components.base.input-display', [
                                'label' => 'Tahun',
                                'value' => $lembaga->tahun,
                            ])
                        </div>
                        <div class="w-1/3">
                            @include('components.base.input-display', [
                                'label' => 'Kota',
                                'value' => $lembaga->kota,
                            ])
                        </div>
                        <div class="w-1/3">
                            @include('components.base.input-display', [
                                'label' => 'Provinsi',
                                'value' => $lembaga->provinsi,
                            ])
                        </div>
                    </div>
                    <div class="flex flex-row gap-3">
                        <div class="w-1/3">
                            @include('components.base.input-display', [
                                'label' => 'Kepala Kantor',
                                'value' => $lembaga->kepala_kantor,
                            ])
                        </div>
                        <div class="w-1/3">
                            @include('components.base.input-display', [
                                'label' => 'NIP',
                                'value' => $lembaga->nip_kepala_kantor,
                            ])
                        </div>
                        <div class="w-1/3">
                            @include('components.base.input-display', [
                                'label' => 'Jabatan',
                                'value' => $lembaga->jabatan,
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
