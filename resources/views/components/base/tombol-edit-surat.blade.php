<a href="{{ route('surat.edit', $surat->id) }}"
    class="flex border font-medium font-sans text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md px-1 shadow-sm hover:shadow-md  border-orange-400 text-slate-800  bg-orange-300 flex-row justify-center items-center gap-1 cursor-pointer">
    @include('components.base.ikon-edit') Edit
</a>
