@extends('layouts.super-admin-layout')

@php

    use Carbon\Carbon;

@endphp

@section('content')
    <div class="bg-white h-full rounded-xl shadow-neutral-400 shadow-lg p-4 flex flex-col gap-y-6 overflow-auto">
        <div class="flex flex-col">
            <div>
                <h4 class="font-sans text-xl font-bold antialiased md:text-2xl lg:text-3xl text-gray-600">Rekapitulasi Surat
                    Masuk
                </h4>
                <h6 class="font-sans text-base font-bold antialiased md:text-lg lg:text-lg text-gray-600">LLDIKTI Wilayah 2
                </h6>
            </div>
        </div>
        <div class="flex flex-col gap-y-2">
            <div>
                <div class="flex flex-row justify-between">
                    <h5 class="font-sans text-lg font-bold antialiased md:text-xl lg:text-xl text-gray-600">Rekapitulasi
                        Surat
                        Masuk</h5>
                    <form action="{{ route('rekapitulasi.export') }}" method="GET" class="inline">
                        <input type="hidden" name="group_by" value="{{ $groupBy }}">
                        <input type="hidden" name="tanggal_{{ $groupBy }}" value="{{ $tanggalInput }}">

                        <button type="submit"
                            class="inline-flex items-center px-2.5 py-1.5 bg-red-600 text-white text-sm font-medium rounded-md shadow cursor-pointer">
                            
                            Export PDF
                        </button>
                    </form>
                </div>

                <hr class="w-full border-t border-gray-300 my-1" />
            </div>


            <form action="{{ route('rekapitulasi.index') }}" method="GET"
                class="flex flex-col md:flex-row px-2 gap-4 my-1 items-stretch md:items-end ">

                <!-- Group By Selector -->
                <div class="flex flex-col w-full md:w-auto">
                    <label for="group_by" class="block text-gray-700 text-sm font-semibold mb-2">Tampilkan Per</label>
                    <select name="group_by" id="group_by"
                        class="w-full px-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="daily" {{ request('group_by') === 'daily' ? 'selected' : '' }}>Harian</option>
                        <option value="weekly" {{ request('group_by') === 'weekly' ? 'selected' : '' }}>Mingguan</option>
                        <option value="monthly" {{ request('group_by') === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                        <option value="yearly" {{ request('group_by') === 'yearly' ? 'selected' : '' }}>Tahunan</option>
                    </select>
                </div>

                <!-- Dynamic Date Input -->
                <div class="w-full md:w-auto">
                    <label for="tanggal_input" class="block text-gray-700 font-semibold mb-2 md:text-sm sm:text-xs">Pilih
                        Tanggal</label>

                    <!-- Harian -->
                    <input type="date" name="tanggal_daily" id="input-daily" class="date-input hidden">

                    <!-- Mingguan -->
                    <input type="week" name="tanggal_weekly" id="input-weekly" class="date-input hidden">

                    <!-- Bulanan -->
                    <input type="month" name="tanggal_monthly" id="input-monthly" class="date-input hidden">

                    <!-- Tahunan -->
                    <select name="tanggal_yearly" id="input-yearly"
                        class="date-input hidden px-2 py-1 border border-gray-300 rounded-lg">
                        @for ($year = now()->year; $year >= 2000; $year--)
                            <option value="{{ $year }}" {{ request('tanggal_yearly') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="flexflex-row gap-3 w-full md:w-auto">
                    <button type="submit"
                        class="inline-flex border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-slate-800 border-slate-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">
                        Tampilkan
                    </button>
                    <a href="{{ route('rekapitulasi.index') }}"
                        class="inline-flex border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-red-800 border-red-800 text-slate-50 hover:bg-red-500 hover:border-red-500">
                        Reset
                    </a>
                </div>
            </form>

            <div class="mt-4 px-2">
                <h4 class="text-xl font-bold mb-4 text-slate-700">
                    Rekapitulasi {{ $waktu ?? 'Tidak ada data waktu' }}
                </h4>
            </div>




            <div class="tab-group w-full">
                {{-- TAB HEADERS --}}
                <div class="flex bg-slate-100 p-0.5 relative rounded-lg" role="tablist">
                    <div
                        class="absolute shadow-sm top-1 left-0.5 h-8 bg-white rounded-md transition-all duration-300 transform scale-x-0 translate-x-0 tab-indicator z-0">
                    </div>
                    @foreach (array_keys($rekap) as $kategori)
                        <a href="#"
                            class="tab-link flex items-center text-sm inline-block py-2 px-4 text-slate-800 transition-all duration-300 relative z-1 mr-1"
                            data-tab-target="tab-{{ $kategori }}">
                            <span class="mr-2 h-4 w-4 bg-slate-400 rounded-full"></span>
                            {{ ucfirst($kategori) }}
                        </a>
                    @endforeach
                </div>



                {{-- TAB CONTENTS --}}
                <div class="mt-4 tab-content-container">
                    @foreach ($rekap as $kategori => $groupedSurats)
                        <div id="tab-{{ $kategori }}" class="tab-content text-slate-800 hidden">
                            @includeIf('components.rekap.card-' . $kategori, [
                                'data' => $groupedSurats,
                            ])
                            @foreach ($groupedSurats as $value => $surats)
                                <div class="my-6">
                                    <h3 class="font-bold mb-2 text-slate-600 text-2xl">{{ $value ?: 'Tanpa Kategori' }}
                                    </h3>
                                    @include('components.table.table', ['surats' => $surats])
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>


        </div>

        @foreach ($rekapPerWaktuDetail as $waktu => $data)
            <div class="mb-8">



                <h4 class="text-xl font-bold mb-4 text-slate-700">Rekapitulasi Surat Masuk:
                    {{ $waktu ?? 'Tidak ada data waktu' }}</h4>

                {{-- Grid Tabel: Klasifikasi, Sifat, Status, Divisi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    {{-- Klasifikasi --}}
                    <div class="overflow-x-auto">
                        <h5 class="text-slate-600 font-semibold mb-2">Klasifikasi</h5>
                        <table class="w-full text-left table-auto text-slate-800 min-w-0">
                            <thead class="border-b border-slate-200 bg-slate-100 text-sm font-medium text-slate-600">
                                <tr class="w-full text-left table-auto text-slate-800 min-w-0">
                                    <th class="px-2.5 py-2 text-start">Klasifikasi</th>
                                    <th class="px-2.5 py-2 text-start">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-slate-800">
                                @foreach ($data['Klasifikasi'] as $klasifikasi => $jumlah)
                                    <tr class="w-full text-left table-auto text-slate-800 min-w-0">
                                        <td class="p-3">{{ $klasifikasi }}</td>
                                        <td class="p-3">{{ $jumlah }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Sifat --}}
                    <div class="overflow-x-auto">
                        <h5 class="text-slate-600 font-semibold mb-2">Sifat</h5>
                        <table class="w-full text-left table-auto text-slate-800 min-w-0">
                            <thead class="border-b border-slate-200 bg-slate-100 text-sm font-medium text-slate-600">
                                <tr class="w-full text-left table-auto text-slate-800 min-w-0">
                                    <th class="px-2.5 py-2 text-start">Sifat</th>
                                    <th class="px-2.5 py-2 text-start">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-slate-800">
                                @foreach ($data['Sifat'] as $sifat => $jumlah)
                                    <tr class="w-full text-left table-auto text-slate-800 min-w-0">
                                        <td class="p-3">{{ $sifat }}</td>
                                        <td class="p-3">{{ $jumlah }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>



                    {{-- Status --}}
                    <div class="overflow-x-auto">
                        <h5 class="text-slate-600 font-semibold mb-2">Status</h5>
                        <table class="w-full text-left table-auto text-slate-800 min-w-0">
                            <thead class="border-b border-slate-200 bg-slate-100 text-sm font-medium text-slate-600">
                                <tr class="text-slate-800 border-b border-slate-300 bg-slate-50">
                                    <th class="px-2.5 py-2 text-start">Status</th>
                                    <th class="px-2.5 py-2 text-start">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-slate-800">
                                @foreach ($data['Status'] as $status => $jumlah)
                                    <tr um text-slate-600">
                                    <tr>
                                        <td class="p-3">{{ $status }}</td>
                                        <td class="p-3">{{ $jumlah }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach



    </div>
@endsection
