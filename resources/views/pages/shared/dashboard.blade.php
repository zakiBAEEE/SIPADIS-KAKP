@php
    $hour = now()->format('H');
    if ($hour >= 5 && $hour < 11) {
        $greeting = 'Selamat Pagi';
    } elseif ($hour >= 11 && $hour < 15) {
        $greeting = 'Selamat Siang';
    } elseif ($hour >= 15 && $hour < 18) {
        $greeting = 'Selamat Sore';
    } else {
        $greeting = 'Selamat Malam';
    }

    $sifatList = ['Penting', 'Segera', 'Rutin', 'Rahasia'];
@endphp

@extends('layouts.super-admin-layout')

@section('content')
    <div class="bg-white h-full rounded-xl shadow-neutral-400 shadow-lg p-4 flex flex-col gap-y-6 overflow-auto">

        {{-- Header --}}
        <div>
            <h4 class="text-xl font-bold text-gray-700">
                {{ $greeting }}, {{ auth()->user()->name }} 👋
            </h4>
            <p class="text-sm text-gray-600">
                Anda login sebagai <span class="font-semibold text-gray-800">
                    {{ auth()->user()->role->name ?? '-' }}
                </span>
                @if (auth()->user()->divisi ?? null)
                    | Divisi: <span class="font-semibold text-gray-800">
                        {{ auth()->user()->divisi->nama_divisi }}
                    </span>
                @endif
            </p>
            <p class="text-gray-600 text-sm md:text-base mt-1">
                Berikut ini adalah surat masuk berdasarkan tingkat urgensi (Sifat Surat) yang saat ini berada dalam tanggung
                jawab anda.
            </p>
        </div>

        {{-- Garis pemisah --}}
        <hr class="border-t border-gray-300 my-1" />

        {{-- Bagian Card Dashboard --}}
        <div class="flex flex-wrap justify-center gap-4">
            @foreach ($sifatList as $sifat)
                @include('components.layout.card-dashboard', [
                    'jenis' => $sifat,
                    'count' => $rekapSifatAktif[$sifat] ?? 0,
                ])
            @endforeach
        </div>

        {{-- Tabs untuk tabel surat --}}
        <div class="tab-group w-full mt-6">
            <div class="flex bg-slate-100 p-0.5 relative rounded-lg" role="tablist">
                <div
                    class="absolute shadow-sm top-1 left-0.5 h-8 bg-white rounded-md transition-all duration-300 transform scale-x-0 translate-x-0 tab-indicator z-0">
                </div>
                @foreach ($sifatList as $index => $sifat)
                    <a href="#"
                        class="tab-link flex items-center text-sm inline-block py-2 px-4 text-slate-800 transition-all duration-300 relative z-1 mr-1"
                        data-tab-target="tab-{{ $sifat }}">
                        <span class="mr-2 h-4 w-4 bg-slate-400 rounded-full"></span>
                        {{ ucfirst($sifat) }}
                    </a>
                @endforeach
            </div>

            <div class="mt-4 tab-content-container">
                @foreach ($sifatList as $index => $sifat)
                    <div id="tab-{{ $sifat }}" class="tab-content text-slate-800 hidden">
                        @include('components.table.table', [
                            'surats' => $listSuratAktif[$sifat] ?? collect(),
                        ])
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
