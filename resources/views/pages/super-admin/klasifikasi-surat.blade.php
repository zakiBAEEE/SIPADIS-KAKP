@extends('layouts.super-admin-layout')

@section('content')
    <div class="bg-white w-full h-full rounded-xl shadow-neutral-400 shadow-lg overflow-scroll p-4">
        {{-- Header --}}
        <div class="flex flex-row justify-between items-center w-full">
            <div>
                <h4 class="font-sans text-xl font-bold antialiased md:text-2xl lg:text-2xl text-gray-600">
                    Rekap Surat {{ $klasifikasi }}
                </h4>
                <h6 class="font-sans text-base font-bold antialiased md:text-lg lg:text-lg text-gray-600">
                    {{ $tanggalRange ? 'Per ' . $tanggalRange : 'Per Hari Ini' }}
                </h6>
            </div>
            <div class="flex flex-row gap-2">
                @include('components.base.collapse-button', [
                    'dataTarget' => 'filterSuratKlasifikasi',
                    'label' => 'Filter',
                ])
            </div>
        </div>

        <hr class="w-full border-t border-gray-300 my-4" />

        {{-- Filter Collapse --}}
        <div class="flex-col transition-[max-height] duration-300 ease-in-out max-h-0 mt-1" id="filterSuratKlasifikasi">
            <form action="{{ route('surat.klasifikasi') }}" method="GET">
                {{-- Hidden values to preserve context --}}
                <input type="hidden" name="tanggal_range" value="{{ request('tanggal_range') }}">
                <input type="hidden" name="klasifikasi" value="{{ request('klasifikasi') }}">

                {{-- Filter form --}}
                <div class="px-4 py-2">
                    <div class="flex flex-row gap-3">
                        <div class="mb-4 space-y-1.5 w-full">
                            @include('components.base.input-surat', [
                                'label' => 'Nomor Surat',
                                'placeholder' => 'Masukkan Nomor Surat',
                                'name' => 'nomor_surat',
                                'value' => request('nomor_surat'),
                            ])
                        </div>
                    </div>

                    <div class="flex flex-row gap-3 items-center">
                        <div class="mb-4 space-y-1.5 w-1/2">
                            @include('components.base.input-surat', [
                                'label' => 'Pengirim',
                                'placeholder' => 'Masukkan Pengirim Surat',
                                'name' => 'pengirim',
                                'value' => request('pengirim'),
                            ])
                        </div>
                        <div class="mb-4 space-y-1.5 w-1/2">
                            @include('components.base.dropdown', [
                                'label' => 'Sifat',
                                'value' => ['Rahasia', 'Penting', 'Segera', 'Rutin'],
                                'name' => 'sifat',
                                'selected' => request('sifat'),
                            ])
                        </div>
                    </div>

                    <div class="space-y-1.5 mb-4">
                        @include('components.base.input-surat', [
                            'label' => 'Perihal',
                            'placeholder' => 'Masukkan Perihal Surat',
                            'name' => 'perihal',
                            'value' => request('perihal'),
                        ])
                    </div>

                    {{-- Tombol --}}
                    <div class="flex flex-row justify-end mb-5 gap-4">
                        <button type="reset" id="resetKlasifikasiForm"
                            class="inline-flex border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-red-800 border-red-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">
                            Reset
                        </button>
                        <button type="submit"
                            class="inline-flex border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-slate-800 border-slate-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">
                            Terapkan
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Tabel dan Pagination --}}
        @include('components.table.table', ['surats' => $surats])
        <div class="mt-4 flex flex-row justify-end">
            @include('components.base.pagination', ['surats' => $surats])
        </div>
    </div>
@endsection
