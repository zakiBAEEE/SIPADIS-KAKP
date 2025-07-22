  <div>
      <h4 class="text-xl font-bold mb-4 text-slate-700">Rekap Waktu: {{ $formattedWaktu }}</h4>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

          {{-- Klasifikasi --}}
          <div class="overflow-x-auto">
              <h5 class="text-slate-600 font-semibold mb-2">Klasifikasi</h5>
              <table class="w-full text-left table-auto text-slate-800 min-w-0">
                  <thead class="border-b border-slate-200 bg-slate-100 text-sm font-medium text-slate-600">
                      <tr class="w-full text-left table-auto text-slate-800 min-w-0">
                          <th class="px-2.5 py-2 text-start">Klasifikasi</th>
                          <th class="px-2.5 py-2 text-start">Jumlah</th>
                      </tr>
                  </thead>
                  <tbody class="text-sm text-slate-800">
                      @foreach ($data['Klasifikasi'] as $klasifikasi => $jumlah)
                          <tr class="w-full text-left table-auto text-slate-800 min-w-0">
                              <td class="p-3">{{ $klasifikasi }}</td>
                              <td class="p-3">{{ $jumlah }}</td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>

          {{-- Sifat --}}
          <div class="overflow-x-auto">
              <h5 class="text-slate-600 font-semibold mb-2">Sifat</h5>
              <table class="w-full text-left table-auto text-slate-800 min-w-0">
                  <thead class="border-b border-slate-200 bg-slate-100 text-sm font-medium text-slate-600">
                      <tr class="w-full text-left table-auto text-slate-800 min-w-0">
                          <th class="px-2.5 py-2 text-start">Sifat</th>
                          <th class="px-2.5 py-2 text-start">Jumlah</th>
                      </tr>
                  </thead>
                  <tbody class="text-sm text-slate-800">
                      @foreach ($data['Sifat'] as $sifat => $jumlah)
                          <tr class="w-full text-left table-auto text-slate-800 min-w-0">
                              <td class="p-3">{{ $sifat }}</td>
                              <td class="p-3">{{ $jumlah }}</td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>

          {{-- Status --}}
          <div class="overflow-x-auto">
              <h5 class="text-slate-600 font-semibold mb-2">Status</h5>
              <table class="w-full text-left table-auto text-slate-800 min-w-0">
                  <thead class="border-b border-slate-200 bg-slate-100 text-sm font-medium text-slate-600">
                      <tr class="text-slate-800 border-b border-slate-300 bg-slate-50">
                          <th class="px-2.5 py-2 text-start">Status</th>
                          <th class="px-2.5 py-2 text-start">Jumlah</th>
                      </tr>
                  </thead>
                  <tbody class="text-sm text-slate-800">
                      @foreach ($data['Status'] as $status => $jumlah)
                          <tr um text-slate-600">
                          <tr>
                              <td class="p-3">{{ $status }}</td>
                              <td class="p-3">{{ $jumlah }}</td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>

  </div>
