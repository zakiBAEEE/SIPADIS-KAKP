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
            <form action="{{-- route(...) --}}" method="GET">
                {{-- @include('components.layout.input-filter-inbox') --}}
                <div class="flex flex-row justify-end mb-5 gap-4">
                    <a href="{{-- route(...) --}}" class="...">Reset</a>
                    <button type="submit" class="...">Terapkan</button>
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