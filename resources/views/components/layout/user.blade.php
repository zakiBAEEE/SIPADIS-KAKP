@auth {{-- Memastikan blok ini hanya ditampilkan jika ada pengguna yang login --}}
<div class="flex flex-row w-full mt-4 ml-3">
    <div class="ml-3 flex flex-col">
        <span class="text-md font-semibold text-gray-900">
            {{ Auth::user()->name }} | {{ Auth::user()->username }}
        </span>
        <span class="text-sm font-normal text-gray-500">
            {{ Auth::user()->role->name }} 
        </span>
    </div>
</div>
@endauth