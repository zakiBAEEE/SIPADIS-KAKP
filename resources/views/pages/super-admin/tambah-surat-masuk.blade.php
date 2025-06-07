@extends('layouts.super-admin-layout')

@section('content')
    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-100 px-6 py-5 text-base text-green-700" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-lg bg-red-100 px-6 py-5 text-base text-red-700" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <div class="bg-white w-full h-full rounded-xl shadow-neutral-400 shadow-lg overflow-scroll p-4">
        <div class="bg-white rounded-lg w-full transition-transform duration-300 ease-out scale-100">
            <div class="pt-4 px-4 flex justify-between items-start">
                <div class="flex flex-col gap-2 w-full">
                    <div class="flex flex-col">
                        <h1 class="text-xl text-gray-600 font-bold">Entry Surat Masuk</h1>
                    </div>
                    <hr class="w-full border-t border-gray-300" />
                </div>
                <button type="button" data-dismiss="modal" aria-label="Close"
                    class="inline-grid place-items-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none data-[shape=circular]:rounded-full text-sm min-w-[34px] min-h-[34px] rounded-full bg-transparent border-transparent text-slate-200-foreground hover:bg-slate-200/10 hover:border-slate-200/10 shadow-none hover:shadow-none outline-none absolute right-2 top-2">
                    <svg width="1.5em" height="1.5em" stroke-width="1.5" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg" color="currentColor" class="h-5 w-5">
                        <path
                            d="M6.75827 17.2426L12.0009 12M17.2435 6.75736L12.0009 12M12.0009 12L6.75827 6.75736M12.0009 12L17.2435 17.2426"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('components.form.form-surat-masuk')
                <div class="px-4">
                    @include('components.base.file-picker', [
                        'label' => 'Upload Surat',
                        'name' => 'file_path',
                    ])
                </div>
                <div class=" px-4 pb-4 flex justify-end gap-2">
                    @include('components.base.tombol-simpan-surat')
                </div>
            </form>
        </div>
    </div>
@endsection
