@extends('layouts.super-admin-layout')

@section('content')
    <div
        class="bg-white h-full rounded-xl shadow-neutral-400 shadow-lg p-4 flex flex-col gap-y-6">
        <div class="flex flex-col">
            <div>
                <h4 class="font-sans text-xl font-bold antialiased md:text-2xl lg:text-2xl text-gray-600">Dashboard
                </h4>
                <h6 class="font-sans text-base font-bold antialiased md:text-lg lg:text-lg text-gray-600">LLDIKTI Wilayah 2
                </h6>
            </div>
        </div>
        <div class="flex flex-col gap-y-2">
            <div>
                <h5 class="font-sans text-lg font-bold antialiased md:text-xl lg:text-xl text-gray-600">Rekapitulasi Surat
                    Masuk</h5>
                <hr class="w-full border-t border-gray-300 my-1" />
            </div>
            <form action="{{ route('surat.home') }}" method="GET" class="flex flex-row px-2 gap-x-4 my-1 items-end">
                <div>
                    <label for="startDate" class="block text-gray-700 text-sm font-semibold mb-2">Pilih Rentang
                        Tanggal</label>
                    <input type="text" name="tanggal_range" id="startDate"
                        class="flatpickr w-full px-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Select Date Range" value="{{ $tanggalRange ?? '' }}" />
                </div>
                <div class="flex flex-col">
                    <label for="group_by" class="block text-gray-700 text-sm font-semibold mb-2">Tampilkan Per</label>
                    <select name="group_by" id="group_by"
                        class="w-full px-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="daily" {{ request('group_by') === 'daily' ? 'selected' : '' }}>Harian</option>
                        <option value="weekly" {{ request('group_by') === 'weekly' ? 'selected' : '' }}>Mingguan</option>
                        <option value="monthly" {{ request('group_by') === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                    </select>
                </div>
                <div class="flex flex-row gap-3">
                    <button type="submit"
                        class="inline-flex border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-slate-800 border-slate-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">
                        Tampilkan
                    </button>
                    <a href="{{ route('surat.home') }}"
                        class="inline-flex border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-red-800 border-red-800 text-slate-50 hover:bg-red-500 hover:border-red-500">
                        Reset
                    </a>
                </div>
            </form>

            <div class="mt-4 px-2">
                <p class="text-lg text-gray-600 font-medium">
                    @if ($tanggalRange)
                        @php
                            $range = explode(' to ', $tanggalRange);
                            $start = \Carbon\Carbon::parse($range[0])->translatedFormat('d M Y');
                            $end = isset($range[1])
                                ? \Carbon\Carbon::parse($range[1])->translatedFormat('d M Y')
                                : $start;
                        @endphp
                        rekapitulasi surat masuk dari <span class="font-semibold">{{ $start }}</span>
                        sampai <span class="font-semibold">{{ $end }}</span>.
                    @else
                        rekapitulasi surat masuk hari ini
                        ({{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}).
                    @endif
                </p>
            </div>
            <div class="flex flex-row gap-4 items-center justify-evenly">
                @include('components.layout.card-dashboard', [
                    'jenis' => 'total',
                    'count' => $rekapRange['total'] ?? 0,
                ])
                @include('components.base.ikon-panah-kanan')
                <div class="flex flex-row gap-2">
                    <a href="{{ route('surat.klasifikasi', ['klasifikasi' => 'Umum', 'tanggal_range' => $tanggalRange]) }}">
                        @include('components.layout.card-dashboard', [
                            'jenis' => 'umum',
                            'count' => $rekapRange['umum'] ?? 0,
                        ])
                    </a>
                    <a
                        href="{{ route('surat.klasifikasi', ['klasifikasi' => 'Pengaduan', 'tanggal_range' => $tanggalRange]) }}">
                        @include('components.layout.card-dashboard', [
                            'jenis' => 'pengaduan',
                            'count' => $rekapRange['pengaduan'] ?? 0,
                        ])
                    </a>
                    <a
                        href="{{ route('surat.klasifikasi', ['klasifikasi' => 'Permintaan Informasi', 'tanggal_range' => $tanggalRange]) }}">
                        @include('components.layout.card-dashboard', [
                            'jenis' => 'permintaan informasi',
                            'count' => $rekapRange['permintaan_informasi'] ?? 0,
                        ])
                    </a>
                </div>
            </div>


            @include('components.layout.chart', [
                'id' => 'suratChartBulanan',
                'series' => $series,
                'categories' => $categories,
            ])
        </div>
    </div>
@endsection
