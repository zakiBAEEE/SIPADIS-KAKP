@extends('layouts.super-admin-layout')

@section('content')
    <div class="bg-white w-full h-full rounded-xl shadow-neutral-400 shadow-lg overflow-scroll p-4">
        <div class="flex flex-row justify-between items-center w-full">
            <div>
                <h4 class="font-sans text-xl font-bold antialiased md:text-2xl lg:text-2xl text-gray-600">Agenda KBU
                </h4>
                <h6 class="font-sans text-base font-bold antialiased md:text-lg lg:text-lg text-gray-600">LLDIKTI Wilayah 2
                </h6>
            </div>
            <div class="flex flex-row gap-2">
                @include('components.base.collapse-button', [
                    'dataTarget' => 'collapseFilterAgendaKbu',
                    'label' => 'Filter',
                ])
            </div>
        </div>
        <hr class="w-full border-t border-gray-300 my-4" />
        <div>
            <div class="flex-col transition-[max-height] duration-300 ease-in-out max-h-0 mt-1" id="collapseFilterAgendaKbu">
                <form action="{{ route('surat.agendaKbu') }}" method="GET">
                    <div class="px-4 py-2">
                        <div class="mb-4 space-y-1.5 w-full">
                            @include('components.base.input-surat', [
                                'label' => 'Nomor Agenda',
                                'placeholder' => 'Masukkan Nomor Agenda',
                                'name' => 'nomor_agenda',
                                'value' => request('nomor_agenda'),
                            ])
                        </div>
                        <div class="flex flex-row gap-3">
                            <div class="mb-4 space-y-1.5 w-1/2">
                                @include('components.base.input-surat', [
                                    'label' => 'Nomor Surat',
                                    'placeholder' => 'Masukkan Nomor Surat',
                                    'name' => 'nomor_surat',
                                    'value' => request('nomor_surat'),
                                ])
                            </div>
                            <div class="mb-4 space-y-1.5 w-1/3">
                                @include('components.base.datepicker', [
                                    'label' => 'Tanggal Surat',
                                    'placeholder' => 'Pilih Tanggal Surat',
                                    'id' => 'filter_tanggal_surat',
                                    'name' => 'filter_tanggal_surat',
                                    'value' => request('filter_tanggal_surat'),
                                ])
                            </div>
                            <div class="mb-4 space-y-1.5 w-1/3">
                                @include('components.base.datepicker', [
                                    'label' => 'Tanggal Terima',
                                    'placeholder' => 'Pilih Tanggal Terima',
                                    'id' => 'filter_tanggal_terima',
                                    'name' => 'filter_tanggal_terima',
                                    'value' => request('filter_tanggal_terima'),
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
                            <div class="mb-4 space-y-1.5 w-1/3">
                                @include('components.base.dropdown', [
                                    'label' => 'Klasifikasi',
                                    'value' => ['Umum', 'Pengaduan', 'Permintaan Informasi'],
                                    'name' => 'klasifikasi_surat',
                                    'selected' => request('klasifikasi_surat'),
                                ])
                            </div>
                            <div class="mb-4 space-y-1.5 w-1/3">
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
                    </div>
                    <div class="flex flex-row justify-end mb-5 gap-4 flex-wrap"> {{-- Tambahkan flex-wrap untuk responsivitas tombol --}}
                        <a href="{{ route('surat.agendaKbu') }}"
                            class="inline-flex items-center justify-center border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-red-800 border-red-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m-15.357-2a8.001 8.001 0 0015.357 2.001M9 15h4.581" />
                            </svg>
                            Reset
                        </a>

                        {{-- Tombol Terapkan Filter (ke agendaKbu) --}}
                        <button type="submit"
                            class="inline-flex items-center justify-center border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-slate-800 border-slate-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                    clip-rule="evenodd" />
                            </svg>
                            Terapkan Filter
                        </button>

                        <button type="submit" formaction="{{ route('surat.printAgendaKbu') }}" {{-- Mengarah ke route printAgenda --}}
                            formmethod="GET" {{-- Pastikan method GET --}} formtarget="_blank" {{-- Opsional: buka di tab baru --}}
                            class="inline-flex items-center justify-center border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-blue-700 border-blue-700 text-slate-50 hover:bg-blue-600 hover:border-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v3a2 2 0 002 2h6a2 2 0 002-2v-3h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v3h6v-3z"
                                    clip-rule="evenodd" />
                            </svg>
                            Cetak Agenda Kbu
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @include('components.table.table-agenda-kbu', ['suratMasuk' => $suratMasuk])
        <div class="mt-4 flex flex-row justify-end">
            @include('components.base.pagination', ['surats' => $suratMasuk])
        </div>
    </div>
@endsection
