@extends('layouts.super-admin-layout')

@section('content')
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
        @include('components.table.table-tim-kerja', ['timKerja' => $timKerja])
        <div class="mt-4 flex flex-row justify-end">
            <div class="flex items-center gap-1">
                {{-- Tombol "Sebelumnya" --}}
                <a href="{{ $timKerja->previousPageUrl() }}"
                    class="inline-flex select-none items-center justify-center rounded-md border border-transparent bg-transparent px-3.5 py-2.5 text-center align-middle text-sm font-medium leading-none text-slate-800 transition-all duration-300 ease-in hover:border-slate-800/5 hover:bg-slate-800/5 {{ $timKerja->onFirstPage() ? 'pointer-events-none opacity-50' : '' }}">
                    <svg width="1.5em" height="1.5em" stroke-width="1.5" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg" color="currentColor" class="mr-1.5 h-4 w-4 stroke-2">
                        <path d="M15 6L9 12L15 18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </svg>Sebelumnya
                </a>

                {{-- Nomor halaman --}}
                @for ($i = 1; $i <= $timKerja->lastPage(); $i++)
                    <a href="{{ $timKerja->url($i) }}"
                        class="inline-grid min-h-[36px] min-w-[36px] select-none place-items-center rounded-md border {{ $i == $timKerja->currentPage() ? 'border-slate-800 bg-slate-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700' : 'border-transparent bg-transparent text-slate-800 hover:border-slate-800/5 hover:bg-slate-800/5' }} text-center align-middle text-sm font-medium leading-none transition-all duration-300 ease-in">
                        {{ $i }}
                    </a>
                @endfor

                {{-- Tombol "Selanjutnya" --}}
                <a href="{{ $timKerja->nextPageUrl() }}"
                    class="inline-flex select-none items-center justify-center rounded-md border border-transparent bg-transparent px-3.5 py-2.5 text-center align-middle text-sm font-medium leading-none text-slate-800 transition-all duration-300 ease-in hover:border-slate-800/5 hover:bg-slate-800/5 {{ !$timKerja->hasMorePages() ? 'pointer-events-none opacity-50' : '' }}">
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
