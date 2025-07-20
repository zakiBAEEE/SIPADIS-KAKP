 @php
     $counts = collect($data)->map->count();
 @endphp


 <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-5">
     <div
         class="p-4 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-700 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Draft</div>
         <div class="text-3xl font-bold">{{ $counts['draft'] ?? 0 }}</div>
     </div>
     <div
         class="p-4 rounded-xl bg-gradient-to-r from-blue-800 to-indigo-900 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Proses Disposisi</div>
         <div class="text-3xl font-bold">{{ $counts['diproses'] ?? 0 }}</div>
     </div>
     <div
         class="p-4 rounded-xl bg-gradient-to-r from-emerald-400 to-cyan-400 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Ditindaklanjuti</div>
         <div class="text-3xl font-bold">{{ $counts['ditindaklanjuti'] ?? 0 }}</div>
     </div>
     <div
         class="p-4 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-700 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Selesai</div>
         <div class="text-3xl font-bold">{{ $counts['selesai'] ?? 0 }}</div>
     </div>
     <div
         class="p-4 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Ditolak</div>
         <div class="text-3xl font-bold">{{ $counts['ditolak'] ?? 0 }}</div>
     </div>
 </div>
