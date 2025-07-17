@extends('layouts.super-admin-layout')

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


    <div class="bg-white h-full rounded-xl shadow-neutral-400 shadow-lg p-4 flex flex-col gap-y-6 overflow-auto">
        <div class="">
            <div class="pt-4 px-4 flex justify-between items-start">
                <div class="flex flex-col gap-2 w-full">
                    <div class="flex flex-col">
                        <h1 class="text-xl text-gray-600 font-bold">Entry Surat Masuk</h1>
                    </div>
                    <hr class="w-full border-t border-gray-300" />
                </div>

            </div>
            <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('components.form.form-surat-masuk')
                <div class="px-4">
                    @include('components.base.file-picker', [
                        'label' => 'Upload Surat',
                        'name' => 'file_path',
                    ])
                    <p class="mt-2 text-sm text-gray-500">* Hanya file bertipe <span
                            class="font-medium text-gray-700">gambar (jpg, jpeg, png)</span> dan <span
                            class="font-medium text-gray-700">PDF</span> yang diperbolehkan.</p>
                    <div class="mt-2">
                        @error('file_path')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <div class=" px-4 pb-4 flex justify-end gap-2">
                    @include('components.base.tombol-simpan-surat')
                </div>
            </form>
        </div>
    </div>
@endsection
