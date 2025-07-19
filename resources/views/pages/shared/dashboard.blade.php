@extends('layouts.super-admin-layout')

@section('content')
    <div class="bg-white h-full rounded-xl shadow-neutral-400 shadow-lg p-4 flex flex-col gap-y-6 overflow-auto">
        <div class="flex flex-col">
            <div>
                <h4 class="text-xl font-bold text-gray-700">
                    Selamat datang, {{ auth()->user()->name }} 👋
                </h4>
                <p class="text-gray-600 text-sm md:text-base">
                    Berikut adalah rekapitulasi surat masuk berdasarkan <span class="font-semibold">tingkat urgensi (Sifat
                        Surat)</span> yang saat ini sedang dalam proses penanganan Anda.
                </p>
            </div>
        </div>
        <div class="flex flex-col gap-y-2">
            {{-- <div>
                <h5 class="font-sans text-lg font-bold antialiased md:text-xl lg:text-xl text-gray-600">Rekapitulasi Surat
                    Masuk</h5> --}}
            <hr class="w-full border-t border-gray-300 my-1" />
        </div>

        <div class="flex flex-row md:gap-4 items-center justify-evenly flex-1 md:flex-wrap md:overflow-hidden overflow-auto">

            <div class="flex flex-row gap-2 flex-1 justify-center">
                <div class="flex flex-row gap-2 flex-1 justify-center">
                    @include('components.layout.card-dashboard', [
                        'jenis' => 'biasa',
                        'count' => $rekapSifatAktif['biasa'] ?? 0,
                    ])
                    @include('components.layout.card-dashboard', [
                        'jenis' => 'penting',
                        'count' => $rekapSifatAktif['penting'] ?? 0,
                    ])
                    @include('components.layout.card-dashboard', [
                        'jenis' => 'segera',
                        'count' => $rekapSifatAktif['segera'] ?? 0,
                    ])
                    @include('components.layout.card-dashboard', [
                        'jenis' => 'rahasia',
                        'count' => $rekapSifatAktif['rahasia'] ?? 0,
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
