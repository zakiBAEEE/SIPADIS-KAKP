@extends('layouts.super-admin-layout')

@section('content')
    <x-layout.page-list-layout>

        {{-- Isi slot "title" dengan judul yang berbeda --}}
        <x-slot:title>
            {{ $pageTitle ?? 'Disposisi Masuk' }}
        </x-slot:title>

        {{-- Isi slot "filterId" dengan ID yang berbeda --}}
        <x-slot:filterId>
            filterInboxDisposisi
        </x-slot:filterId>

        {{-- Isi slot "filterForm" dengan form filter untuk inbox (mungkin berbeda) --}}
        <x-slot:filterForm>
            <form action="{{ route('inbox.ditolak') }}" method="GET">
                <div class="px-4 py-2">
                    <div class="flex flex-row gap-3">
                        <div class="mb-4 space-y-1.5 w-1/3">
                            @include('components.base.dropdown', [
                                'label' => 'Status Penerima',
                                'value' => ['Menunggu', 'Dilihat', 'Diteruskan', 'Dikembalikan'],
                                'name' => 'status',
                                'selected' => request('status'),
                            ])
                        </div>
                        <div class="mb-4 space-y-1.5 w-1/3">
                            @include('components.base.dropdown', [
                                'label' => 'Tipe Aksi',
                                'value' => ['Teruskan', 'Revisi', 'Kembalikan'],
                                'name' => 'tipe_aksi',
                                'selected' => request('tipe_aksi'),
                            ])
                        </div>
                        <div class="mb-4 space-y-1.5 w-1/3">
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
                        <a href="{{ route('inbox.ditolak') }}"
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

        {{-- Isi slot "tableContent" dengan tabel inbox yang sudah kita buat --}}
        <x-slot:tableContent>
            @include('components.table.table-inbox', ['disposisis' => $disposisis])
        </x-slot:tableContent>

        {{-- Isi slot "paginationLinks" dengan data dari inbox --}}
        <x-slot:paginationLinks>
            {{ $disposisis->links() }}
        </x-slot:paginationLinks>
    </x-layout.page-list-layout>
@endsection
