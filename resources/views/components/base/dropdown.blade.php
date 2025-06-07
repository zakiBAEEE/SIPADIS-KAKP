@php
    $id = $id ?? '';
    $placeholder = $placeholder ?? 'Pilih salah satu';
    $name = $name ?? '';
    $value = $value ?? [];
    $selected = $selected ?? old($name);
@endphp

<div>
    @if ($label)
        <label for="{{ $id }}" class="font-sans text-sm text-slate-800 font-bold mb-2 block">
            {{ $label }}
        </label>
    @endif

    <div class="w-full max-w-sm min-w-[200px] relative">
        <select id="{{ $id }}" name="{{ $name }}"
            class="w-full bg-transparent text-slate-700 text-sm border border-slate-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-slate-400 ring ring-transparent hover:ring-slate-800/10 focus:ring-slate-800/10 hover:border-slate-800 shadow-sm focus:shadow cursor-pointer appearance-none">

            <option disabled {{ $selected ? '' : 'selected' }}>{{ $placeholder }}</option>

            @foreach ($value as $item)
                @if (is_array($item) && isset($item['label']) && isset($item['children']))
                    <optgroup label="{{ $item['label'] }}">
                        @foreach ($item['children'] as $child)
                            @if (is_array($child) && isset($child['value'], $child['display']))
                                <option value="{{ $child['value'] }}"
                                    {{ $selected == $child['value'] ? 'selected' : '' }}>
                                    {{ $child['display'] }}
                                </option>
                            @endif
                        @endforeach
                    </optgroup>
                @elseif (is_array($item) && isset($item['value'], $item['display']))
                    <option value="{{ $item['value'] }}" {{ $selected == $item['value'] ? 'selected' : '' }}>
                        {{ $item['display'] }}
                    </option>
                @elseif (is_string($item))
                    <option value="{{ $item }}" {{ $selected == $item ? 'selected' : '' }}>
                        {{ $item }}
                    </option>
                @endif
            @endforeach

        </select>

        <!-- SVG Panah Dropdown -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2"
            stroke="currentColor" class="h-5 w-5 ml-1 absolute top-2.5 right-2.5 text-slate-700 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
        </svg>
    </div>
</div>
