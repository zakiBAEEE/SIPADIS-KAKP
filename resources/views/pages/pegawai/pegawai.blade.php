@extends('layouts.main-layout')

@section('content')
    @if (session('success'))
        <div class="js-dismissable-alert fixed top-6 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md flex items-center justify-between rounded-lg bg-green-100 px-6 py-5 text-base text-green-700 shadow-lg transition-opacity duration-300"
            role="alert">
            <span>{{ session('success') }}</span>
            <button type="button" class="js-close-alert text-green-700 hover:text-green-900">
                &times;
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="js-dismissable-alert fixed top-6 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md flex items-center justify-between rounded-lg bg-red-100 px-6 py-5 text-base text-red-700 shadow-lg transition-opacity duration-300"
            role="alert">
            <span>{{ session('error') }}</span>
            <button type="button" class="js-close-alert text-red-700 hover:text-red-900">
                &times;
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="js-dismissable-alert fixed top-6 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md flex items-center justify-between rounded-lg bg-red-100 px-6 py-5 text-base text-red-700 shadow-lg transition-opacity duration-300"
            role="alert">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="js-close-alert text-red-700 hover:text-red-900">
                &times;
            </button>
        </div>
    @endif

    <div class="bg-white w-full h-full rounded-xl shadow-neutral-400 shadow-lg overflow-scroll p-4">
        <div class="flex flex-row justify-between items-center w-full">
            <div>
                <h4 class="font-sans text-xl font-bold antialiased md:text-2xl lg:text-2xl text-gray-600">Data Pegawai
                </h4>
                <h6 class="font-sans text-base font-bold antialiased md:text-lg lg:text-lg text-gray-600">LLDIKTI Wilayah 2
                </h6>
            </div>
            <div class="flex flex-row gap-2 items-center">
                @include('components.modal.modal-tambah-pegawai')
                @include('components.base.collapse-button', [
                    'dataTarget' => 'collapseFilterPegawai',
                    'label' => 'Filter',
                ])
            </div>
        </div>
        <hr class="w-full border-t border-gray-300 my-4" />


        <div class="mb-2">
            <div class="flex-col transition-[max-height] duration-300 ease-in-out max-h-0 mt-1" id="collapseFilterPegawai">
                <form action="{{ route('pegawai.index') }}" method="GET">
                    <div class="px-4 py-2">
                        <div class="flex flex-col sm:flex-row gap-3 items-center justify-center">
                            <div class="mb-4 space-y-1.5 sm:w-1/3 w-full">
                                @include('components.base.input-surat', [
                                    'label' => 'Nama',
                                    'placeholder' => 'Masukkan Nama',
                                    'name' => 'nama',
                                    'value' => request('nama'),
                                ])
                            </div>

                            <div class="mb-4 space-y-1.5 sm:w-1/3 w-full">
                                @include('components.base.input-surat', [
                                    'label' => 'Username',
                                    'placeholder' => 'Masukkan Username',
                                    'name' => 'username',
                                    'value' => request('username'),
                                ])
                            </div>

                            <div class="mb-4 space-y-1.5 sm:w-1/3 w-full">
                                @include('components.base.dropdown', [
                                    'label' => 'Role',
                                    'value' => ['Admin', 'Kepala LLDIKTI', 'KBU', 'Katimja', 'Staf'],
                                    'name' => 'role',
                                    'selected' => request('role'),
                                ])
                            </div>

                        </div>
                    </div>
                    <div class="flex flex-row justify-end mb-5 gap-4 flex-wrap"> {{-- Tambahkan flex-wrap untuk responsivitas tombol --}}
                        <a href="{{ route('pegawai.index') }}"
                            class="inline-flex items-center justify-center border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-red-800 border-red-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m-15.357-2a8.001 8.001 0 0015.357 2.001M9 15h4.581" />
                            </svg>
                            Reset
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-slate-800 border-slate-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                    clip-rule="evenodd" />
                            </svg>
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>



        @include('components.table.table-pegawai', ['users' => $users])
        <div class="mt-4 flex flex-row justify-center sm:justify-end overflow-auto">
            <div class="flex items-center gap-1 overflow-x-auto">
                {{-- Tombol "Sebelumnya" --}}
                <a href="{{ $users->previousPageUrl() }}"
                    class="inline-flex select-none items-center justify-center rounded-md border border-transparent bg-transparent px-3.5 py-2.5 text-center align-middle text-sm font-medium leading-none text-slate-800 transition-all duration-300 ease-in hover:border-slate-800/5 hover:bg-slate-800/5 {{ $users->onFirstPage() ? 'pointer-events-none opacity-50' : '' }}">
                    <svg width="1.5em" height="1.5em" stroke-width="1.5" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg" color="currentColor" class="mr-1.5 h-4 w-4 stroke-2">
                        <path d="M15 6L9 12L15 18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        </path>
                    </svg>Sebelumnya
                </a>

                {{-- Nomor halaman --}}
                @for ($i = 1; $i <= $users->lastPage(); $i++)
                    <a href="{{ $users->url($i) }}"
                        class="inline-grid min-h-[36px] min-w-[36px] select-none place-items-center rounded-md border {{ $i == $users->currentPage() ? 'border-slate-800 bg-slate-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700' : 'border-transparent bg-transparent text-slate-800 hover:border-slate-800/5 hover:bg-slate-800/5' }} text-center align-middle text-sm font-medium leading-none transition-all duration-300 ease-in">
                        {{ $i }}
                    </a>
                @endfor

                {{-- Tombol "Selanjutnya" --}}
                <a href="{{ $users->nextPageUrl() }}"
                    class="inline-flex select-none items-center justify-center rounded-md border border-transparent bg-transparent px-3.5 py-2.5 text-center align-middle text-sm font-medium leading-none text-slate-800 transition-all duration-300 ease-in hover:border-slate-800/5 hover:bg-slate-800/5 {{ !$users->hasMorePages() ? 'pointer-events-none opacity-50' : '' }}">
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
