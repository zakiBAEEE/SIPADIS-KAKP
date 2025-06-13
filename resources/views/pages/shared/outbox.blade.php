@extends('layouts.super-admin-layout')

@section('content')
    <x-layout.page-list-layout>
        <x-slot:title>{{ $pageTitle ?? 'Outbox' }}</x-slot:title>

        <x-slot:filterId>filterOutbox</x-slot:filterId>

        <x-slot:filterForm>
            {{-- Form filter untuk Outbox bisa ditambahkan di sini --}}
        </x-slot:filterForm>

        <x-slot:tableContent>
            @include('components.table.table-outbox', ['disposisis' => $disposisis])
        </x-slot:tableContent>

        <x-slot:paginationLinks>
            {{ $disposisis->links() }}
        </x-slot:paginationLinks>

    </x-layout.page-list-layout>
@endsection
