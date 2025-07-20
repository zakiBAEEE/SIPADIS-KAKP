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
@endphp


@extends('layouts.super-admin-layout')

@section('content')
    <div class="bg-white h-full rounded-xl shadow-neutral-400 shadow-lg p-4 flex flex-col gap-y-6 overflow-auto">
        <div class="flex flex-col">
            <div>

                <h4 class="text-xl font-bold text-gray-700">
                    {{ $greeting }}, {{ auth()->user()->name }} 👋
                </h4>
                <p class="text-gray-600 text-sm md:text-base">
                    Berikut ini adalah surat masuk berdasarkan tingkat urgensi (Sifat Surat) yang saat ini berada dalam tanggung jawab anda.
                </p>
            </div>
        </div>
        <div class="flex flex-col gap-y-2">
            {{-- <div>
                <h5 class="font-sans text-lg font-bold antialiased md:text-xl lg:text-xl text-gray-600">Rekapitulasi Surat
                    Masuk</h5> --}}
            <hr class="w-full border-t border-gray-300 my-1" />
        </div>

        <div class="flex flex-row md:gap-4  justify-evenly flex-1 md:flex-wrap md:overflow-hidden overflow-auto">

            <div class="flex flex-row gap-2 flex-1 justify-center">
                <div class="flex flex-row gap-2 flex-1 justify-center">
                    @include('components.layout.card-dashboard', [
                        'jenis' => 'Rahasia',
                        'count' => $rekapSifatAktif['Rahasia'] ?? 0,
                    ])
                    @include('components.layout.card-dashboard', [
                        'jenis' => 'Penting',
                        'count' => $rekapSifatAktif['Penting'] ?? 0,
                    ])
                    @include('components.layout.card-dashboard', [
                        'jenis' => 'Segera',
                        'count' => $rekapSifatAktif['Segera'] ?? 0,
                    ])
                    @include('components.layout.card-dashboard', [
                        'jenis' => 'Rutin',
                        'count' => $rekapSifatAktif['Rutin'] ?? 0,
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
