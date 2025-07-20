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
            <hr class="border-t border-gray-300 my-3" />
            <h2 class="text-xl font-bold text-gray-700 mt-2">
                Overview
            </h2>
            @if (auth()->user()->role->name !== 'Staf')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-5">
                    <div class="p-4 rounded-xl bg-gradient-to-r from-blue-500 to-blue-700 text-white shadow-lg">
                        <div class="text-sm">Surat Masuk (Belum Ditindaklanjuti)</div>
                        <div class="text-3xl font-bold">{{ $inboxSuratCount }}</div>
                    </div>
                    <div class="p-4 rounded-xl bg-gradient-to-r from-yellow-500 to-yellow-700 text-white shadow-lg">
                        <div class="text-sm">Surat Dikembalikan</div>
                        <div class="text-3xl font-bold">{{ $dikembalikanKeAndaCount }}</div>
                    </div>
                    <div class="p-4 rounded-xl bg-gradient-to-r from-green-500 to-green-700 text-white shadow-lg">
                        <div class="text-sm">Surat Terkirim Hari Ini</div>
                        <div class="text-3xl font-bold">{{ $suratTerdisposisiHariIniCount }}</div>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-5">
                    <div class="p-4 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-700 text-white shadow-lg">
                        <div class="text-sm">Surat Perlu Tindakan</div>
                        <div class="text-3xl font-bold">{{ $diprosesCount }}</div>
                    </div>
                    <div class="p-4 rounded-xl bg-gradient-to-r from-orange-500 to-orange-700 text-white shadow-lg">
                        <div class="text-sm">Surat Ditindaklanjuti</div>
                        <div class="text-3xl font-bold">{{ $ditindaklanjutiCount }}</div>
                    </div>
                    <div class="p-4 rounded-xl bg-gradient-to-r from-red-500 to-red-700 text-white shadow-lg">
                        <div class="text-sm">Surat Ditolak (Hari Ini)</div>
                        <div class="text-3xl font-bold">{{ $ditolakHariIniCount }}</div>
                    </div>
                    <div class="p-4 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-700 text-white shadow-lg">
                        <div class="text-sm">Surat Selesai (Hari Ini)</div>
                        <div class="text-3xl font-bold">{{ $selesaiHariIniCount }}</div>
                    </div>
                </div>
            @endif

        </div>

        {{-- Garis pemisah --}}
        <p class="text-gray-600 text-sm md:text-base">
            Berikut ini adalah surat masuk berdasarkan tingkat urgensi (Sifat Surat) yang saat ini berada dalam tanggung
            jawab anda.
        </p>

        {{-- Bagian Card Dashboard --}}
        <div class="flex flex-wrap justify-center gap-4">
            @foreach ($sifatList as $sifat)
                @include('components.layout.card-dashboard', [
                    'jenis' => $sifat,
                    'count' => $rekapSifatAktif[$sifat] ?? 0,
                ])
            @endforeach
        </div>

        <h2 class="text-xl font-bold text-gray-700">
            Akses Cepat
        </h2>

        {{-- Tabs untuk tabel surat --}}
        <div class="tab-group w-full ">
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
