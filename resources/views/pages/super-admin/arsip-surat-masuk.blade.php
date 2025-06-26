@extends('layouts.super-admin-layout')

@section('content')
    {{-- Gunakan komponen layout kita --}}
    <x-layout.page-list-layout>

        {{-- Isi slot "title" --}}
        <x-slot:title>
            Arsip Surat Masuk
        </x-slot:title>

        {{-- Isi slot "filterId" --}}
        <x-slot:filterId>
            filterSuratDisposisi
        </x-slot:filterId>

        {{-- Isi slot "filterForm" --}}
        <x-slot:filterForm>
            <form action="{{ route('surat.arsip') }}" method="GET">
                @include('components.layout.input-filter-surat')
                <div class="flex flex-row justify-end mb-5 gap-4">
                    <a href="{{ route('surat.denganDisposisi') }}"
                        class="inline-flex border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-red-800 border-red-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">Reset</a>
                    <button type="submit"
                        class="inline-flex border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-slate-800 border-slate-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">Terapkan</button>
                </div>
            </form>
        </x-slot:filterForm>

        {{-- Isi slot "tableContent" --}}
        <x-slot:tableContent>
            @include('components.table.table', ['surats' => $surats]) {{-- Asumsi tabel surat --}}
        </x-slot:tableContent>
    </x-layout.page-list-layout>
    
    <div class="mt-4 flex flex-row justify-end">
        @include('components.base.pagination', ['surats' => $surats])
    </div>
@endsection
