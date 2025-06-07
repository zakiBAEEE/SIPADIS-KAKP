@extends('layouts.super-admin-layout')

@section('content')
    <div class="bg-white w-full h-full rounded-xl shadow-neutral-400 shadow-lg overflow-scroll p-4">
        <div class="flex flex-row justify-between items-center w-full">
            <div>
                <h4 class="font-sans text-xl font-bold antialiased md:text-2xl lg:text-2xl text-gray-600">Surat Masuk 
                   Belum Terdisposisi
                </h4>
                <h6 class="font-sans text-base font-bold antialiased md:text-lg lg:text-lg text-gray-600">LLDIKTI Wilayah 2
                </h6>
            </div>
            <div class="flex flex-row gap-2">
                @include('components.base.collapse-button', [
                    'dataTarget' => 'filterSuratTanpaDisposisi',
                    'label' => 'Filter',
                ])
            </div>
        </div>
        <hr class="w-full border-t border-gray-300 my-4" />
        <div>
            <div class="flex-col transition-[max-height] duration-300 ease-in-out max-h-0 mt-1"
                id='filterSuratTanpaDisposisi'>
                <form action="{{ route('surat.tanpaDisposisi') }}" method="GET">
                    @include('components.layout.input-filter-surat')
                    <div class="flex flex-row justify-end mb-5 gap-4">
                        <a href="{{ route('surat.tanpaDisposisi') }}"
                            class="inline-flex border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-red-800 border-red-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">
                            Reset
                        </a>
                        <button type="submit"
                            class="inline-flex border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-slate-800 border-slate-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">
                            Terapkan
                        </button>
                    </div>
                </form>
            </div>

        </div>
        @include('components.table.table', ['surats' => $surats])
        <div class="mt-4 flex flex-row justify-end">
            @include('components.base.pagination', ['surats' => $surats])
        </div>
    </div>
@endsection
