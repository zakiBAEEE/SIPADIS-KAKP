 @php
     $counts = collect($data)->map->count();
 @endphp


 <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-5">
     <div
         class="p-4 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-700 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Rahasia</div>
         <div class="text-3xl font-bold">{{ $counts['Rahasia'] ?? 0 }}</div>
     </div>
     <div
         class="p-4 rounded-xl bg-gradient-to-r from-blue-800 to-indigo-900 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Penting</div>
         <div class="text-3xl font-bold">{{ $counts['Penting'] ?? 0 }}</div>
     </div>
     <div
         class="p-4 rounded-xl bg-gradient-to-r from-emerald-400 to-cyan-400 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Segera</div>
         <div class="text-3xl font-bold">{{ $counts['Segera'] ?? 0 }}</div>
     </div>
     <div
         class="p-4 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-700 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Rutin</div>
         <div class="text-3xl font-bold">{{ $counts['Rutin'] ?? 0 }}</div>
     </div>
 </div>
