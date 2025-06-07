<a href="{{ route('disposisi.cetak', $surat->id) }}"
    class="inline-flex border font-medium font-sans text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md px-1 shadow-sm hover:shadow-md bg-transparent border-slate-800 text-slate-800 flex-row justify-center items-center gap-1"
    target="_blank">
    @include('components.base.ikon-print') Cetak
</a>
