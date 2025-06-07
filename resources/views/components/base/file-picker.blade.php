<div class="pb-4">
    <label class="block font-sans text-sm text-slate-800 font-bold mb-2">
        {{ $label }}
    </label>

    <div id="drop-area"
        class="group relative w-full flex flex-col items-center justify-center px-4 py-10 border-2 border-dashed rounded-lg cursor-pointer transition-colors
         border-slate-300 bg-white text-slate-500 hover:border-blue-400 hover:bg-blue-50
        
         slate-700 h-full">
        <input type="file" name="{{ $name }}" id="fileInput"
            class="absolute inset-0 opacity-0 z-10 cursor-pointer h-full" />

        <div class="flex flex-col items-center pointer-events-none h-full">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-8 w-8 mb-2 text-slate-400 group-hover:text-blue-500"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M4 12l8-8m0 0l8 8m-8-8v12" />
            </svg>
            <p id="drop-text" class="text-sm">Klik atau tarik file ke sini</p>
        </div>
    </div>
</div>
