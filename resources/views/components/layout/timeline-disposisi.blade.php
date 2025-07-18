<div class="flex w-1/4 flex-col items-center">
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
                        Waktu: {{ \Carbon\Carbon::parse($disposisi->created_at)->translatedFormat('d F Y H:i') }}
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
                    <p class="text-sm font-medium">{{ $disposisi->penerima->name ?? 'N/A' }}</p>
                    @if ($disposisi->penerima && $disposisi->penerima->divisi)
                        <p class="text-xs text-gray-500">{{ $disposisi->penerima->divisi->nama_divisi }}
                            ({{ $disposisi->penerima->role->name }})
                        </p>
                    @else
                        <p class="text-xs text-gray-500">{{ $disposisi->penerima->role->name ?? '' }}</p>
                    @endif
                    <small class="text-sm text-slate-600">
                        Waktu: {{ \Carbon\Carbon::parse($disposisi->created_at)->translatedFormat('d F Y H:i') }}
                    </small>
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
</div>
