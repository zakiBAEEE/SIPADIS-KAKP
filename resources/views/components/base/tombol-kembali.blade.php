{{-- BELUM BISA DIPAKEEE --}}


{{-- Logika untuk menentukan URL "Kembali" yang cerdas --}}
@php
    // 1. Ambil URL sebelumnya dari sesi Laravel.
    $previousUrl = url()->previous();

    // 2. Ambil URL saat ini untuk perbandingan.
    $currentUrl = url()->current();

    // 3. Tentukan URL "aman" sebagai fallback (misalnya dashboard utama).
    $fallbackUrl = route('surat.show'); 

    // 4. Cek apakah URL sebelumnya valid untuk digunakan.
    // URL dianggap tidak valid jika:
    // - Sama dengan URL saat ini (terjadi saat refresh).
    // - Mengarah kembali ke halaman login.
    if ($previousUrl == $currentUrl || $previousUrl == route('login')) {
        $backUrl = $fallbackUrl;
    } else {
        $backUrl = $previousUrl;
    }
@endphp

{{-- Tombol "Kembali" yang sekarang menggunakan URL dinamis --}}
<a href="{{ $backUrl }}"
   class="inline-flex border font-medium font-sans text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md px-1 shadow-sm hover:shadow-md bg-transparent border-slate-800 text-slate-800 flex-row justify-center items-center gap-1"
   data-toggle="tooltip" data-placement="left-start" data-title="Kembali"
   data-tooltip-class="bg-slate-950 text-white text-xs rounded-md py-1 px-2 shadow-md z-50">
    @include('components.base.ikon-kembali')
</a>