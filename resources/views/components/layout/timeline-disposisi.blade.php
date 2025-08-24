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
                            @include('components.svg.dilihat')
                        @else
                            {{-- ⏳ Ikon Belum Dilihat / Diteruskan --}}
                            @include('components.svg.wait')
                        @endif
                    </span>
                </div>

                {{-- Content Column --}}
                <div class="flex-1 pb-8">
                    @if ($disposisi->penerima->role->name == 'Staf')
                        <p class="text-sm text-black font-bold">
                            {{ $disposisi->penerima->timKerja->nama_timKerja }} ({{ $disposisi->penerima->role->name }})
                        </p>
                    @else
                        <p class="text-sm text-black font-bold">{{ $disposisi->penerima->name ?? '' }}</p>
                        @if ($disposisi->penerima && $disposisi->penerima->timKerja)
                            <p class="text-xs text-gray-500">
                                {{ $disposisi->penerima->timKerja->nama_timKerja }}
                                ({{ $disposisi->penerima->role->name }})
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
                        @include('components.svg.ditindaklanjuti')
                    @elseif ($status === 'ditolak')
                        @include('components.svg.ditolak')
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
