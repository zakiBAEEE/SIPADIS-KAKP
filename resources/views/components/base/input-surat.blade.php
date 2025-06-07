@props([
    'label' => '',
    'name',
    'placeholder' => '',
    'value' => '',
])

<div class="flex flex-col gap-1 w-full">
    <label for="{{ $name }}" class="text-sm text-slate-700 font-semibold">{{ $label }}</label>
    <input type="text" name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}"
        class="px-4 py-2 rounded-md border text-sm focus:ring-2 focus:ring-slate-400 focus:outline-none
               @error($name) border-red-500 bg-red-50 @else border-slate-300 @enderror">
    @error($name)
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
