<div class="flex items-center gap-1">
    {{-- Tombol "Sebelumnya" --}}
    <a href="{{ $surats->previousPageUrl() }}"
        class="inline-flex select-none items-center justify-center rounded-md border border-transparent bg-transparent px-3.5 py-2.5 text-center align-middle text-sm font-medium leading-none text-slate-800 transition-all duration-300 ease-in hover:border-slate-800/5 hover:bg-slate-800/5 {{ $surats->onFirstPage() ? 'pointer-events-none opacity-50' : '' }}">
        <svg width="1.5em" height="1.5em" stroke-width="1.5" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg" color="currentColor" class="mr-1.5 h-4 w-4 stroke-2">
            <path d="M15 6L9 12L15 18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>Sebelumnya
    </a>

    {{-- Nomor halaman --}}
    @for ($i = 1; $i <= $surats->lastPage(); $i++)
        <a href="{{ $surats->url($i) }}"
            class="inline-grid min-h-[36px] min-w-[36px] select-none place-items-center rounded-md border {{ $i == $surats->currentPage() ? 'border-slate-800 bg-slate-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700' : 'border-transparent bg-transparent text-slate-800 hover:border-slate-800/5 hover:bg-slate-800/5' }} text-center align-middle text-sm font-medium leading-none transition-all duration-300 ease-in">
            {{ $i }}
        </a>
    @endfor

    {{-- Tombol "Selanjutnya" --}}
    <a href="{{ $surats->nextPageUrl() }}"
        class="inline-flex select-none items-center justify-center rounded-md border border-transparent bg-transparent px-3.5 py-2.5 text-center align-middle text-sm font-medium leading-none text-slate-800 transition-all duration-300 ease-in hover:border-slate-800/5 hover:bg-slate-800/5 {{ !$surats->hasMorePages() ? 'pointer-events-none opacity-50' : '' }}">
        Selanjutnya
        <svg width="1.5em" height="1.5em" stroke-width="1.5" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg" color="currentColor" class="ml-1.5 h-4 w-4 stroke-2">
            <path d="M9 6L15 12L9 18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
    </a>
</div>
