<div class="flex w-1/2 sm:w-1/4 flex-col items-center">
    @php
        $previousPenerimaId = null;
        $staffCheckpointShown = false;
    @endphp

    @forelse ($disposisis as $index => $disposisi)
        {{-- Checkpoint: Pengirim --}}
        @php
            $penerimaRole = strtolower(optional($disposisi->penerima->role)->name);
            $skipPengirim = $penerimaRole === 'staf' && $staffCheckpointShown;
        @endphp

        @if (($index === 0 || optional($disposisi->pengirim)->id !== $previousPenerimaId) && !$skipPengirim)
            <div class="flex w-full min-w-full">
                {{-- Timeline Column --}}
                <div class="relative w-12 flex flex-col items-center">
                    <div class="absolute top-0 h-full w-0.5 bg-slate-300"></div>
                    <span class="z-10 grid h-10 w-10 place-items-center rounded-full bg-slate-200">
                        📤
                    </span>
                </div>

                {{-- Content Column --}}
                <div class="flex-1 pb-8">
                    <p class="font-bold text-slate-800">{{ $disposisi->pengirim->name ?? '-' }}</p>
                    <small class="text-sm text-slate-600">
                        Instruksi: {{ $disposisi->catatan ?? '-' }}<br>
                        Waktu: {{ \Carbon\Carbon::parse($disposisi->updated_at)->translatedFormat('d F Y H:i') }}
                    </small>
                </div>
            </div>
        @endif

        @php
            $status = strtolower($disposisi->status);
            $isDilihatAtauDiteruskan = in_array($status, ['dilihat', 'diteruskan']);
            $previousPenerimaId = optional($disposisi->penerima)->id;
        @endphp

        @php
            $roleName = strtolower(optional($disposisi->penerima->role)->name);
            $shouldSkip = $roleName === 'staf' && $staffCheckpointShown;
        @endphp

        @if (!$shouldSkip)
            <div class="flex w-full min-w-full">
                {{-- Timeline Column --}}
                <div class="relative w-12 flex flex-col items-center">
                    <div class="absolute top-0 h-full w-0.5 bg-slate-300"></div>
                    <span class="z-10 grid h-10 w-10 place-items-center rounded-full bg-slate-200">
                        @if ($isDilihatAtauDiteruskan)
                            {{-- ✔️ Ikon Sudah Dilihat / Diteruskan --}}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"
                                class="w-5 h-5 text-blue-600 fill-current">
                                <path
                                    d="M24.64,52.06a5.55,5.55,0,0,1-3.94-1.63L6.43,36.16a5.57,5.57,0,0,1,0-7.87,5.58,5.58,0,0,1,7.88,0L24.64,38.62l1.85-1.85a2,2,0,1,1,2.83,2.83l-3.26,3.26a2,2,0,0,1-2.83,0L11.48,31.11a1.57,1.57,0,0,0-2.22,2.22L23.53,47.6a1.59,1.59,0,0,0,2.22,0l29-29a1.57,1.57,0,0,0-2.22-2.21L36.63,32.29a2,2,0,0,1-2.83-2.83L49.69,13.57a5.57,5.57,0,0,1,7.88,7.87l-29,29A5.54,5.54,0,0,1,24.64,52.06Z" />
                            </svg>
                        @else
                            {{-- ⏳ Ikon Menunggu --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 text-slate-800"
                                viewBox="0 0 297 297">
                                <path
                                    d="M251.01,277.015h-17.683l-0.002-31.558c0-31.639-17.358-60.726-48.876-81.901c-3.988-2.682-6.466-8.45-6.466-15.055
                            s2.478-12.373,6.464-15.053c31.52-21.178,48.878-50.264,48.88-81.904V19.985h17.683c5.518,0,9.992-4.475,9.992-9.993
                            c0-5.518-4.475-9.992-9.992-9.992H45.99c-5.518,0-9.992,4.475-9.992,9.992c0,5.519,4.475,9.993,9.992,9.993h17.683v31.558
                            c0,31.642,17.357,60.728,48.875,81.903c3.989,2.681,6.467,8.448,6.467,15.054s-2.478,12.373-6.466,15.053
                            c-31.519,21.177-48.876,50.263-48.876,81.903v31.558H45.99c-5.518,0-9.992,4.475-9.992,9.993c0,5.519,4.475,9.992,9.992,9.992
                            h205.02c5.518,0,9.992-4.474,9.992-9.992C261.002,281.489,256.527,277.015,251.01,277.015z M83.657,245.456
                            c0-33.425,25.085-55.269,40.038-65.314c9.583-6.441,15.304-18.269,15.304-31.642s-5.721-25.2-15.305-31.642
                            c-14.952-10.046-40.037-31.89-40.037-65.315V19.985h129.686l-0.002,31.558c0,33.424-25.086,55.269-40.041,65.317
                            c-9.581,6.441-15.301,18.269-15.301,31.64s5.72,25.198,15.303,31.642c14.953,10.047,40.039,31.892,40.041,65.314v31.558h-3.312
                            c-8.215-30.879-50.138-64.441-55.377-68.537c-3.616-2.828-8.694-2.826-12.309,0c-5.239,4.095-47.163,37.658-55.378,68.537h-3.311
                            V245.456z M189.033,277.015h-81.067c6.584-15.391,25.383-34.873,40.534-47.76C163.652,242.142,182.45,261.624,189.033,277.015z" />
                                <path d="M148.497,191.014c2.628,0,5.206-1.069,7.064-2.928c1.868-1.858,2.928-4.437,2.928-7.064s-1.06-5.206-2.928-7.065
                            c-1.858-1.857-4.436-2.927-7.064-2.927c-2.628,0-5.206,1.069-7.064,2.927c-1.859,1.859-2.928,4.438-2.928,7.065
                            s1.068,5.206,2.928,7.064C143.291,189.944,145.869,191.014,148.497,191.014z" />
                                <path d="M148.5,138.019c5.519,0,9.992-4.474,9.992-9.992v-17.664c0-5.518-4.474-9.993-9.992-9.993s-9.992,4.475-9.992,9.993v17.664
                            C138.508,133.545,142.981,138.019,148.5,138.019z" />
                            </svg>
                        @endif
                    </span>
                </div>

                {{-- Content Column --}}
                <div class="flex-1 pb-8">
                    @if ($disposisi->penerima->role->name == 'Staf')
                        <p class="text-sm text-black font-bold">
                            {{ $disposisi->penerima->divisi->nama_divisi }} ({{ $disposisi->penerima->role->name }})
                        </p>
                    @else
                        <p class="text-sm text-black font-bold">{{ $disposisi->penerima->name ?? '' }}</p>
                        @if ($disposisi->penerima && $disposisi->penerima->divisi)
                            <p class="text-xs text-gray-500">
                                {{ $disposisi->penerima->divisi->nama_divisi }} ({{ $disposisi->penerima->role->name }})
                            </p>
                        @endif
                    @endif

                    {{-- Hanya tampilkan instruksi jika bukan penerima terakhir --}}
                    @if (!$loop->last)
                        <small class="text-sm text-slate-600">
                            Instruksi: {{ $disposisi->catatan ?? '-' }}<br>
                            Waktu: {{ \Carbon\Carbon::parse($disposisi->updated_at)->translatedFormat('d F Y H:i') }}
                        </small>
                    @else
                        <small class="text-sm text-slate-600">
                            Waktu: {{ \Carbon\Carbon::parse($disposisi->updated_at)->translatedFormat('d F Y H:i') }}
                        </small>
                    @endif
                </div>


            </div>
            @if ($roleName === 'staf')
                @php $staffCheckpointShown = true; @endphp
            @endif
        @endif

        {{-- Checkpoint: Penerima --}}

    @empty
        <div class="text-slate-500 italic">Belum ada disposisi.</div>
    @endforelse

    @if (in_array(strtolower($surat->status), ['dikembalikan', 'ditindaklanjuti', 'selesai', 'ditolak']))
        <div class="flex w-full min-w-full">
            {{-- Timeline Column --}}
            <div class="relative w-12 flex flex-col items-center">
                <div
                    class="absolute top-0 {{ in_array(strtolower($surat->status), ['selesai', 'ditindaklanjuti', 'dikembalikan', 'ditolak']) ? 'h-0' : 'h-full' }} w-0.5 bg-slate-300">
                </div>

                {{-- Icon Berdasarkan Status --}}
                <span class="z-10 grid h-10 w-10 place-items-center rounded-full bg-slate-200">
                    @php
                        $status = strtolower($surat->status);
                    @endphp

                    @if ($status === 'selesai')
                        ✅
                    @elseif ($status === 'ditindaklanjuti')
                        {!! '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 1024 1024"><path d="M661.333333 170.666667l253.866667 34.133333-209.066667 209.066667zM362.666667 853.333333L108.8 819.2l209.066667-209.066667zM170.666667 362.666667L204.8 108.8l209.066667 209.066667z" fill="#9C27B0"/><path d="M198.4 452.266667l-89.6 17.066666c-2.133333 14.933333-2.133333 27.733333-2.133333 42.666667 0 98.133333 34.133333 192 98.133333 264.533333l64-55.466666C219.733333 663.466667 192 588.8 192 512c0-19.2 2.133333-40.533333 6.4-59.733333zM512 106.666667c-115.2 0-217.6 49.066667-292.266667 125.866666l59.733334 59.733334C339.2 230.4 420.266667 192 512 192c19.2 0 40.533333 2.133333 59.733333 6.4l14.933334-83.2C563.2 108.8 537.6 106.666667 512 106.666667zM825.6 571.733333l89.6-17.066666c2.133333-14.933333 2.133333-27.733333 2.133333-42.666667 0-93.866667-32-185.6-91.733333-258.133333l-66.133333 53.333333c46.933333 57.6 72.533333 130.133333 72.533333 202.666667 0 21.333333-2.133333 42.666667-6.4 61.866666zM744.533333 731.733333C684.8 793.6 603.733333 832 512 832c-19.2 0-40.533333-2.133333-59.733333-6.4l-14.933334 83.2c25.6 4.266667 51.2 6.4 74.666667 6.4 115.2 0 217.6-49.066667 292.266667-125.866667l-59.733334-57.6z" fill="#9C27B0"/><path d="M853.333333 661.333333l-34.133333 253.866667-209.066667-209.066667z" fill="#9C27B0"/></svg>' !!}
                    @elseif ($status === 'ditolak')
                        {!! '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512"><style>.st0{fill:#333;}</style><path class="st0" d="M263.24,43.5c-117.36,0-212.5,95.14-212.5,212.5s95.14,212.5,212.5,212.5s212.5-95.14,212.5-212.5S380.6,43.5,263.24,43.5z M367.83,298.36c17.18,17.18,17.18,45.04,0,62.23v0c-17.18,17.18-45.04,17.18-62.23,0l-42.36-42.36l-42.36,42.36c-17.18,17.18-45.04,17.18-62.23,0v0c-17.18-17.18-17.18-45.04,0-62.23L201.01,256l-42.36-42.36c-17.18-17.18-17.18-45.04,0-62.23v0c17.18-17.18,45.04-17.18,62.23,0l42.36,42.36l42.36-42.36c17.18-17.18,45.04-17.18,62.23,0v0c17.18,17.18,17.18,45.04,0,62.23L325.46,256L367.83,298.36z"/></svg>' !!}
                    @elseif ($status === 'dikembalikan')
                        🔁
                    @endif
                </span>
            </div>

            {{-- Content Column --}}
            <div class="flex-1 pb-8">
                <p class="font-bold text-green-800">Status Akhir Surat</p>
                <p class="text-sm text-gray-700 capitalize">
                    {{ $surat->status }} pada
                    {{ \Carbon\Carbon::parse($surat->updated_at)->translatedFormat('d F Y H:i') }}
                </p>
            </div>
        </div>
    @endif

</div>
