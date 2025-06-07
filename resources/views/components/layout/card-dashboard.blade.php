@props(['jenis', 'count'])

<div
    class="w-[200px] overflow-hidden rounded-lg border border-slate-200 bg-white shadow-lg shadow-slate-950/5 flex justify-center items-center h-[110px]">
    <div class="h-full w-full rounded px-3 py-2 flex flex-col items-center justify-center gap-2">
        @if ($jenis === 'total')
            @include('components.base.ikon-surat')
        @elseif($jenis === 'umum')
            @include('components.base.ikon-surat-umum')
        @elseif($jenis === 'pengaduan')
            @include('components.base.ikon-surat-pengaduan')
        @elseif($jenis === 'permintaan informasi')
            @include('components.base.ikon-surat-permintaan-informasi')
        @else
            @include('components.base.ikon-surat')
        @endif

        <h6 class="font-sans text-base font-bold antialiased md:text-lg lg:text-xl text-gray-700 text-center">
            @if ($jenis === 'total')
                {{ $count ?? 0 }} Surat {{ ucfirst($jenis) }}
            @else
                {{ $count ?? 0 }} {{ ucfirst($jenis) }}
            @endif

        </h6>
    </div>
</div>
