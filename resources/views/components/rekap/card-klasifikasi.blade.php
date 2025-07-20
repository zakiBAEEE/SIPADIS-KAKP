 @php
     $counts = collect($data)->map->count();
 @endphp

 <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-5 ">
     <div class="p-4 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-700 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Umum</div>
         <div class="text-3xl font-bold">{{ $counts['Umum'] ?? 0 }}</div>
     </div>
     <div class="p-4 rounded-xl bg-gradient-to-r from-orange-500 to-orange-700 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Pengaduan</div>
         <div class="text-3xl font-bold">{{ $counts['Pengaduan'] ?? 0 }}</div>
     </div>
     <div class="p-4 rounded-xl bg-gradient-to-r from-red-500 to-red-700 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Permintaan Informasi</div>
         <div class="text-3xl font-bold">{{ $counts['Permintaan Informasi'] ?? 0 }}</div>
     </div>

 </div>
