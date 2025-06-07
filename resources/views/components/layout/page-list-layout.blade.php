<div class="bg-white w-full h-full rounded-xl shadow-neutral-400 shadow-lg overflow-scroll p-4">

    <div class="flex flex-row justify-between items-center w-full">
        <div>
            {{-- Judul halaman akan diisi secara dinamis --}}
            <h4 class="font-sans text-xl font-bold antialiased md:text-2xl lg:text-2xl text-gray-600">
                {{ $title }}
            </h4>
            <h6 class="font-sans text-base font-bold antialiased md:text-lg lg:text-lg text-gray-600">
                LLDIKTI Wilayah 2
            </h6>
        </div>
        <div class="flex flex-row gap-2">
            {{-- Tombol Filter, targetnya juga dinamis --}}
            @include('components.base.collapse-button', [
                'dataTarget' => $filterId,
                'label' => 'Filter',
            ])
        </div>
    </div>
    <hr class="w-full border-t border-gray-300 my-4" />

    <div>
        <div class="flex-col transition-[max-height] duration-300 ease-in-out max-h-0 mt-1" id="{{ $filterId }}">
            {{ $filterForm }}
        </div>
    </div>

    {{ $tableContent }}

    <div class="mt-4 flex flex-row justify-end">
        {{ $paginationLinks }}
    </div>

</div>
