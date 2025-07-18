<div class="overflow-x-auto">
    <table class="w-full text-left text-sm border border-slate-200 rounded shadow">
        <tbody class="divide-y divide-slate-100">

            <tr class="hover:bg-slate-50">
                <th class="px-4 py-3 bg-slate-50 font-semibold text-slate-700 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M9 12h6m2 0a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v3a2 2 0 002 2h10z" />
                    </svg>
                    Nomor Surat
                </th>
                <td class="px-4 py-3 text-slate-800">{{ $surat->nomor_surat }}</td>
            </tr>

            <tr class="hover:bg-slate-50">
                <th class="px-4 py-3 bg-slate-50 font-semibold text-slate-700 flex items-center gap-2">
                    📅 Tanggal Surat
                </th>
                <td class="px-4 py-3 text-slate-800">
                    {{ \Carbon\Carbon::parse($surat->tanggal_surat)->translatedFormat('d F Y') }}
                </td>
            </tr>

            <tr class="hover:bg-slate-50">
                <th class="px-4 py-3 bg-slate-50 font-semibold text-slate-700 flex items-center gap-2">
                    📨 Tanggal Terima
                </th>
                <td class="px-4 py-3 text-slate-800">
                    {{ \Carbon\Carbon::parse($surat->created_at)->translatedFormat('d F Y') }}
                </td>
            </tr>

            <tr class="hover:bg-slate-50">
                <th class="px-4 py-3 bg-slate-50 font-semibold text-slate-700 flex items-center gap-2">
                    👤 Pengirim
                </th>
                <td class="px-4 py-3 text-slate-800">{{ $surat->pengirim }}</td>
            </tr>

            <tr class="hover:bg-slate-50">
                <th class="px-4 py-3 bg-slate-50 font-semibold text-slate-700 flex items-center gap-2">
                    🏢 Asal Instansi
                </th>
                <td class="px-4 py-3 text-slate-800">{{ $surat->asal_instansi }}</td>
            </tr>

            <tr class="hover:bg-slate-50">
                <th class="px-4 py-3 bg-slate-50 font-semibold text-slate-700 flex items-center gap-2">
                    📧 Email Pengirim
                </th>
                <td class="px-4 py-3 text-slate-800">{{ $surat->email_pengirim }}</td>
            </tr>

            <tr class="hover:bg-slate-50">
                <th class="px-4 py-3 bg-slate-50 font-semibold text-slate-700 flex items-center gap-2">
                    🗂️ Klasifikasi
                </th>
                <td class="px-4 py-3 text-slate-800">{{ $surat->klasifikasi_surat }}</td>
            </tr>

            <tr class="hover:bg-slate-50">
                <th class="px-4 py-3 bg-slate-50 font-semibold text-slate-700 flex items-center gap-2">
                    ⚡ Sifat
                </th>
                <td class="px-4 py-3 text-slate-800">{{ $surat->sifat }}</td>
            </tr>

            <tr class="hover:bg-slate-50">
                <th class="px-4 py-3 bg-slate-50 font-semibold text-slate-700 flex items-center gap-2">
                    📝 Perihal
                </th>
                <td class="px-4 py-3 text-slate-800">{{ $surat->perihal }}</td>
            </tr>

        </tbody>
    </table>
</div>
