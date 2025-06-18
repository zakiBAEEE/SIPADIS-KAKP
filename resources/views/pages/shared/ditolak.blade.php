@extends('layouts.super-admin-layout')

@section('content')
    {{-- Kita bisa gunakan kembali komponen layout halaman daftar --}}
    <x-layout.page-list-layout>
        <x-slot:title>{{ $pageTitle ?? 'Surat Ditolak' }}</x-slot:title>
        
        <x-slot:filterId>filterDitolak</x-slot:filterId>
        
        <x-slot:filterForm>
            {{-- Form filter bisa ditambahkan di sini jika perlu --}}
        </x-slot:filterForm>

        <x-slot:tableContent>
            @include('components.table.table-ditolak', ['disposisis' => $disposisis])
        </x-slot:tableContent>
        
        <x-slot:paginationLinks>
            {{ $disposisis->links() }}
        </x-slot:paginationLinks>

    </x-layout.index-layout>
@endsection