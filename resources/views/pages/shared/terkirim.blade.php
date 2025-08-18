@extends('layouts.super-admin-layout')

@section('content')
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

    <x-layout.page-list-layout>

        <x-slot:title>
            Surat Terkirim
        </x-slot:title>

        <x-slot:filterId>
            filterSuratTerkirim
        </x-slot:filterId>

        <x-slot:filterForm>
            <form action="{{ route('surat.terkirim') }}" method="GET">
                @include('components.layout.input-filter-surat')
                <div class="flex flex-row justify-end mb-5 gap-4">
                    <button type="button" id="resetDisposisiForm"
                        class="inline-flex border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-red-800 border-red-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">
                        Reset
                    </button>
                    <button type="submit"
                        class="inline-flex border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-slate-800 border-slate-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">Terapkan</button>
                </div>
            </form>
        </x-slot:filterForm>

        <x-slot:tableContent>
            @include('components.table.tabel-arsip-surat', ['surats' => $surats]) {{-- Asumsi tabel surat --}}
        </x-slot:tableContent>
    </x-layout.page-list-layout>

    <div class="mt-4 flex flex-row justify-center sm:justify-end overflow-auto">
        @include('components.base.pagination', ['surats' => $surats])
    </div>
@endsection
