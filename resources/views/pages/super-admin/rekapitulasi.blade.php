@extends('layouts.super-admin-layout')

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
                <h5 class="font-sans text-lg font-bold antialiased md:text-xl lg:text-xl text-gray-600">Rekapitulasi Surat
                    Masuk</h5>
                <hr class="w-full border-t border-gray-300 my-1" />
            </div>


            <form action="{{ route('rekapitulasi') }}" method="GET"
                class="flex flex-col md:flex-row px-2 gap-4 my-1 items-stretch md:items-end">

                <!-- Datepicker -->
                <div class="w-full md:w-auto">
                    <label for="startDate" class="block text-gray-700 font-semibold mb-2 md:text-sm sm:text-xs">
                        Pilih Tanggal
                    </label>
                    <input type="text" name="tanggal_range" id="startDate"
                        class="flatpickr w-full px-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Select Date Range" value="{{ $tanggalRange ?? '' }}" />
                </div>

                <!-- Select -->
                {{-- <div class="flex flex-col w-full md:w-auto">
                    <label for="group_by" class="block text-gray-700 text-sm font-semibold mb-2">Tampilkan Per</label>
                    <select name="group_by" id="group_by"
                        class="w-full px-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="daily" {{ request('group_by') === 'daily' ? 'selected' : '' }}>Harian</option>
                        <option value="weekly" {{ request('group_by') === 'weekly' ? 'selected' : '' }}>Mingguan</option>
                        <option value="monthly" {{ request('group_by') === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                    </select>
                </div> --}}

                <!-- Tombol -->
                <div class="flexflex-row gap-3 w-full md:w-auto">
                    <button type="submit"
                        class="inline-flex border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-slate-800 border-slate-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">
                        Tampilkan
                    </button>
                    <a href="{{ route('rekapitulasi') }}"
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
                        Rekapitulasi surat masuk dari <span class="font-semibold">{{ $start }}</span>
                        sampai <span class="font-semibold">{{ $end }}</span>.
                    @else
                        rekapitulasi surat masuk hari ini
                        ({{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}).
                    @endif
                </p>
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
                                    <h3 class="font-bold mb-2 text-slate-600 text-2xl">{{ $value ?: 'Tanpa Kategori' }}</h3>
                                    @include('components.table.table', ['surats' => $surats])
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection
