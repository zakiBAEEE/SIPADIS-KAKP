 @php
     $counts = collect($data)->map->count();

 @endphp

 <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-5">
     <div
         class="p-4 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-700 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Belmawa</div>
         <div class="text-3xl font-bold">{{ $counts['Belmawa'] ?? 0 }}</div>
     </div>
     <div
         class="p-4 rounded-xl bg-gradient-to-r from-blue-800 to-indigo-900 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Riset & Pengembangan</div>
         <div class="text-3xl font-bold">{{ $counts['Riset dan Pengembangan'] ?? 0 }}</div>
     </div>
     <div
         class="p-4 rounded-xl bg-gradient-to-r from-emerald-400 to-cyan-400 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Humas</div>
         <div class="text-3xl font-bold">{{ $counts['Humas'] ?? 0 }}</div>
     </div>
     <div
         class="p-4 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-700 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Tata Usaha</div>
         <div class="text-3xl font-bold">{{ $counts['Tata Usaha'] ?? 0 }}</div>
     </div>
     <div
         class="p-4 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Perencanaan & Keuangan</div>
         <div class="text-3xl font-bold">{{ $counts['Perencanaan & Keuangan'] ?? 0 }}</div>
     </div>
     <div
         class="p-4 rounded-xl bg-gradient-to-r from-emerald-400 to-cyan-400 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Kelembagaan</div>
         <div class="text-3xl font-bold">{{ $counts['Kelembagaan'] ?? 0 }}</div>
     </div>
     <div
         class="p-4 rounded-xl bg-gradient-to-r from-emerald-500 to-emerald-700 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Sistem Informasi</div>
         <div class="text-3xl font-bold">{{ $counts['Sistem Informasi'] ?? 0 }}</div>
     </div>
     <div
         class="p-4 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 text-white shadow-lg flex flex-col items-center justify-center">
         <div class="text-lg font-bold">Sumber Daya</div>
         <div class="text-3xl font-bold">{{ $counts['Sumber Daya'] ?? 0 }}</div>
     </div>
 </div>
