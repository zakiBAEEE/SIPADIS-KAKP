@extends('layouts.super-admin-layout')

@section('content')
  
    @if (session('success'))
       
        <div role="alert"
            class="js-dismissable-alert fixed top-5 right-5 z-50 flex max-w-[35rem] items-center rounded-lg border border-green-500 bg-green-500 p-3 text-white shadow-lg transition-all duration-300 ease-in-out"
            style="opacity: 1; transform: translateY(0);">

            <div class="m-1.5 w-full font-sans text-base font-medium leading-none">{{ session('success') }}</div>

            <button type="button" class="js-close-alert p-1 absolute top-1 right-1" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div role="alert"
            class="js-dismissable-alert fixed top-5 right-5 z-50 flex max-w-[35rem] items-center rounded-lg border border-red-500 bg-red-500 p-3 text-white shadow-lg transition-all duration-300 ease-in-out"
            style="opacity: 1; transform: translateY(0);">

            <div class="m-1.5 w-full font-sans text-base font-medium leading-none">{{ session('error') }}</div>

            <button type="button" class="js-close-alert p-1 absolute top-1 right-1" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    <div class="bg-white w-full h-full rounded-xl shadow-neutral-400 shadow-lg overflow-scroll p-4">
        <div class="flex flex-row justify-between items-center w-full">
            <div>
                <h4 class="font-sans text-xl font-bold antialiased md:text-2xl lg:text-2xl text-gray-600">Tim Kerja
                </h4>
                <h6 class="font-sans text-base font-bold antialiased md:text-lg lg:text-lg text-gray-600">LLDIKTI Wilayah 2
                </h6>
            </div>
            <div class="flex flex-row gap-2">
                @include('components.layout.modal-tambah-tim-kerja')
            </div>
        </div>
        <hr class="w-full border-t border-gray-300 my-4" />
        @include('components.table.table-tim-kerja', ['divisis' => $divisis])
        <div class="mt-4 flex flex-row justify-end">
            <div class="flex items-center gap-1">
                {{-- Tombol "Sebelumnya" --}}
                <a href="{{ $divisis->previousPageUrl() }}"
                    class="inline-flex select-none items-center justify-center rounded-md border border-transparent bg-transparent px-3.5 py-2.5 text-center align-middle text-sm font-medium leading-none text-slate-800 transition-all duration-300 ease-in hover:border-slate-800/5 hover:bg-slate-800/5 {{ $divisis->onFirstPage() ? 'pointer-events-none opacity-50' : '' }}">
                    <svg width="1.5em" height="1.5em" stroke-width="1.5" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg" color="currentColor" class="mr-1.5 h-4 w-4 stroke-2">
                        <path d="M15 6L9 12L15 18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </svg>Sebelumnya
                </a>

                {{-- Nomor halaman --}}
                @for ($i = 1; $i <= $divisis->lastPage(); $i++)
                    <a href="{{ $divisis->url($i) }}"
                        class="inline-grid min-h-[36px] min-w-[36px] select-none place-items-center rounded-md border {{ $i == $divisis->currentPage() ? 'border-slate-800 bg-slate-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700' : 'border-transparent bg-transparent text-slate-800 hover:border-slate-800/5 hover:bg-slate-800/5' }} text-center align-middle text-sm font-medium leading-none transition-all duration-300 ease-in">
                        {{ $i }}
                    </a>
                @endfor

                {{-- Tombol "Selanjutnya" --}}
                <a href="{{ $divisis->nextPageUrl() }}"
                    class="inline-flex select-none items-center justify-center rounded-md border border-transparent bg-transparent px-3.5 py-2.5 text-center align-middle text-sm font-medium leading-none text-slate-800 transition-all duration-300 ease-in hover:border-slate-800/5 hover:bg-slate-800/5 {{ !$divisis->hasMorePages() ? 'pointer-events-none opacity-50' : '' }}">
                    Selanjutnya
                    <svg width="1.5em" height="1.5em" stroke-width="1.5" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg" color="currentColor" class="ml-1.5 h-4 w-4 stroke-2">
                        <path d="M9 6L15 12L9 18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
@endsection
