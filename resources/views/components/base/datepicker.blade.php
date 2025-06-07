@php
    // Definisikan semua variabel supaya tidak error kalau ada yang lupa kirim
    $id = $id ?? '';
    $label = $label ?? '';
    $placeholder = $placeholder ?? '';
    $name = $name ?? '';
    $value = $value ?? '';
@endphp

<div>
    <label for="{{ $id }}"
        class="font-sans text-sm text-slate-800 font-bold mb-2">{{ $label }}</label>
    <div class="relative w-full">
        <input type="text" id="{{ $id }}" name="{{ $name }}" placeholder="{{ $placeholder }}"
            value="{{ old($name, $value) }}"
            class="w-full aria-disabled:cursor-not-allowed outline-none focus:outline-none text-slate-800 placeholder:text-slate-600/60 bg-transparent ring-transparent border border-slate-200 transition-all duration-300 ease-in disabled:opacity-50 disabled:pointer-events-none data-[error=true]:border-error data-[success=true]:border-success select-none data-[shape=pill]:rounded-full text-sm rounded-md py-2 px-2.5 ring shadow-sm data-[icon-placement=start]:ps-9 data-[icon-placement=end]:pe-9 hover:border-slate-800 hover:ring-slate-800/10 focus:border-slate-800 focus:ring-slate-800/10 peer" />
    </div>
</div>
