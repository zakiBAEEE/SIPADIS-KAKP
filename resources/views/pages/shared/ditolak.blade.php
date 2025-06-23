@extends('layouts.super-admin-layout')

@section('content')
    {{-- Kita bisa gunakan kembali komponen layout halaman daftar --}}
    <x-layout.page-list-layout>
        <x-slot:title>{{ $pageTitle ?? 'Surat Ditolak' }}</x-slot:title>

        <x-slot:filterId>filterDitolak</x-slot:filterId>

        <x-slot:filterForm>
            <form action="{{ route('inbox.index') }}" method="GET">
                <div class="px-4 py-2">

                    <div class="flex flex-row gap-3">
                        <div class="mb-4 space-y-1.5 w-full">
                            @include('components.base.datepicker', [
                                'label' => 'Tanggal Kirim',
                                'placeholder' => 'Pilih Tanggal Terikirim',
                                'id' => 'filter_tanggal_terkirim',
                                'name' => 'filter_tanggal_terkirim',
                                'value' => request('filter_tanggal_terkirim'),
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

                    <div class="flex flex-row justify-end mb-5 gap-4">
                        <a href="{{ route('inbox.index') }}"
                            class="inline-flex border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-red-800 border-red-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">
                            Reset
                        </a>
                        <button type="submit"
                            class="inline-flex border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-slate-800 border-slate-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">
                            Terapkan
                        </button>
                    </div>
            </form>
        </x-slot:filterForm>

        <x-slot:tableContent>
            @include('components.table.table-ditolak', ['disposisis' => $disposisis])
        </x-slot:tableContent>

        <x-slot:paginationLinks>
            {{ $disposisis->links() }}
        </x-slot:paginationLinks>

        </x-layout.index-layout>
    @endsection
