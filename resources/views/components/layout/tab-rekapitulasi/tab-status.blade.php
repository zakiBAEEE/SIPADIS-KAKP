<div>
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-5">
        <div class="p-4 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-700 text-white shadow-lg">
            <div class="text-sm">Surat : Draft</div>
            <div class="text-3xl font-bold">0</div>
        </div>
        <div class="p-4 rounded-xl bg-gradient-to-r from-blue-200 to-cyan-200 text-white shadow-lg">
            <div class="text-sm">Surat : Proses Disposisi</div>
            <div class="text-3xl font-bold">0</div>
        </div>
        <div class="p-4 rounded-xl bg-gradient-to-r from-emerald-400 to-cyan-400 text-white shadow-lg">
            <div class="text-sm">Surat : Ditindaklanjuti</div>
            <div class="text-3xl font-bold">6</div>
        </div>
        <div class="p-4 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-700 text-white shadow-lg">
            <div class="text-sm">Surat : Selesai</div>
            <div class="text-3xl font-bold">7</div>
        </div>
        <div class="p-4 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-lg">
            <div class="text-sm">Surat : Ditolak</div>
            <div class="text-3xl font-bold">7</div>
        </div>
    </div>
    {{-- <div class="tab-group w-full mt-5">
        <div class="flex bg-slate-100 p-0.5 relative rounded-lg" role="tablist">
            <div
                class="absolute shadow-sm top-1 left-0.5 h-8 bg-white rounded-md transition-all duration-300 transform scale-x-0 translate-x-0 tab-indicator z-0">
            </div>

            @foreach ($sifatList as $index => $sifat)
                <a href="#"
                    class="tab-link flex items-center text-sm {{ $index === 0 ? 'active' : '' }} inline-block py-2 px-4 text-slate-800 transition-all duration-300 relative z-1 mr-1"
                    data-tab-target="tab-{{ $sifat }}">
                    <span class="mr-2 h-4 w-4 bg-slate-400 rounded-full"></span>
                    {{ ucfirst($sifat) }}
                </a>
            @endforeach
        </div>

        <div class="mt-4 tab-content-container">
            @foreach ($sifatList as $index => $sifat)
                <div id="tab-{{ $sifat }}"
                    class="tab-content text-slate-800 {{ $index === 0 ? 'block' : 'hidden' }}">
                    @include('components.table.table', [
                        'surats' => $suratsBySifat[$sifat] ?? collect(),
                    ])
                </div>
            @endforeach
        </div>
    </div> --}}

    {{-- <div class="tab-group w-full mt-5">
        <div class="flex bg-slate-100 p-0.5 relative rounded-lg" role="tablist">
            <div
                class="absolute shadow-sm top-1 left-0.5 h-8 bg-white rounded-md transition-all duration-300 transform scale-x-0 translate-x-0 tab-indicator z-0">
            </div>

            @foreach ($tabs as $index => $label)
                <a href="#"
                    class="tab-link flex items-center text-sm {{ $index === 0 ? 'active' : '' }} inline-block py-2 px-4 text-slate-800 transition-all duration-300 relative z-1 mr-1"
                    data-tab-target="tab-{{ Str::slug($label) }}">
                    <span class="mr-2 h-4 w-4 bg-slate-400 rounded-full"></span>
                    {{ ucfirst($label) }}
                </a>
            @endforeach
        </div>

        <div class="mt-4 tab-content-container">
            @foreach ($tabs as $index => $label)
                <div id="tab-{{ Str::slug($label) }}"
                    class="tab-content text-slate-800 {{ $index === 0 ? 'block' : 'hidden' }}">
                    @include('components.table.table', [
                        'surats' => $tabData[$label] ?? collect(),
                    ])
                </div>
            @endforeach
        </div>
    </div> --}}

    @php
        $group = 'inner-' . uniqid();
    @endphp

    {{-- <div class="tab-group w-full mt-5" data-tab-group="{{ $group }}">
        <div class="flex bg-slate-100 p-0.5 relative rounded-lg" role="tablist">
            <div
                class="absolute shadow-sm top-1 left-0.5 h-8 bg-white rounded-md transition-all duration-300 transform scale-x-0 translate-x-0 tab-indicator z-0">
            </div>

            @foreach ($tabs as $index => $label)
                @php $slug = Str::slug($label); @endphp
                <a href="#"
                    class="tab-link-inner flex items-center text-sm {{ $index === 0 ? 'active' : '' }} inline-block py-2 px-4 text-slate-800 transition-all duration-300 relative z-1 mr-1"
                    data-tab-target="tab-{{ $group }}-{{ $slug }}" data-tab-group="{{ $group }}">
                    <span class="mr-2 h-4 w-4 bg-slate-400 rounded-full"></span>
                    {{ ucfirst($label) }}
                </a>
            @endforeach
        </div>

        <div class="mt-4 tab-content-container">
            @foreach ($tabs as $index => $label)
                @php $slug = Str::slug($label); @endphp
                <div id="tab-{{ $group }}-{{ $slug }}"
                    class="tab-content-inner text-slate-800 {{ $index === 0 ? 'block' : 'hidden' }}"
                    data-tab-group="{{ $group }}">
                    @include('components.table.table', [
                        'surats' => $tabData[$label] ?? collect(),
                    ])
                </div>
            @endforeach
        </div>
    </div> --}}

    <div class="tabs w-full mt-5" data-tabs="tabs" id="tabs-{{ $group }}">
    <ul class="tab-list flex bg-slate-100 p-0.5 relative rounded-lg" role="tablist">
        @foreach ($tabs as $index => $label)
            @php $slug = Str::slug($label); @endphp
            <li role="presentation">
                <button
                    class="tab {{ $index === 0 ? 'tab-active' : '' }} inline-block py-2 px-4 text-sm text-slate-800"
                    data-tab-target="#tab-{{ $group }}-{{ $slug }}"
                    type="button"
                    role="tab">
                    {{ ucfirst($label) }}
                </button>
            </li>
        @endforeach
    </ul>

    <div class="tab-content-container mt-4">
        @foreach ($tabs as $index => $label)
            @php $slug = Str::slug($label); @endphp
            <div
                id="tab-{{ $group }}-{{ $slug }}"
                class="tab-content {{ $index === 0 ? '' : 'hidden' }}"
                role="tabpanel">
                @include('components.table.table', [
                    'surats' => $tabData[$label] ?? collect(),
                ])
            </div>
        @endforeach
    </div>
</div>


</div>
