<div class="flex w-1/4 flex-col items-center">
    @php $previousPenerimaId = null; @endphp

    @forelse ($disposisis as $index => $disposisi)
        {{-- Checkpoint: Pengirim --}}
        @if ($index === 0 || optional($disposisi->pengirim)->id !== $previousPenerimaId)
            <div class="flex w-full overflow-auto">
                {{-- Timeline Column --}}
                <div class="relative w-12 flex flex-col items-center">
                    <div class="absolute top-0 h-full w-0.5 bg-slate-300"></div>
                    <span
                        class="z-10 grid h-10 w-10 place-items-center rounded-full bg-slate-200 text-xl text-slate-800">
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
            $icon = match ($status) {
                'menunggu' => '⏳',
                'dilihat' => '👁️',
                'diteruskan' => '🔁',
                'kembalikan', 'dikembalikan' => '↩️',
                default => '📥',
            };

            $previousPenerimaId = optional($disposisi->penerima)->id;
        @endphp

        {{-- Checkpoint: Penerima --}}
        <div class="flex w-full overflow-auto">
            {{-- Timeline Column --}}
            <div class="relative w-12 flex flex-col items-center">
                <div class="absolute top-0 h-full w-0.5 bg-slate-300"></div>
                <span class="z-10 grid h-10 w-10 place-items-center rounded-full bg-slate-200 text-xl text-slate-800">
                    {{ $icon }}
                </span>
            </div>

            {{-- Content Column --}}
            <div class="flex-1 pb-8">
                <p class="text-sm font-medium">{{ $disposisi->penerima->name ?? 'N/A' }}</p>
                @if ($disposisi->penerima && $disposisi->penerima->divisi)
                    <p class="text-xs text-gray-500">{{ $disposisi->penerima->divisi->nama_divisi }}
                        ({{ $disposisi->penerima->role->name }})</p>
                @else
                    <p class="text-xs text-gray-500">{{ $disposisi->penerima->role->name ?? '' }}</p>
                @endif
                <small class="mt-2 text-sm text-slate-600">Status: {{ ucfirst($disposisi->status) ?? '-' }}</small>
            </div>
        </div>
    @empty
        <div class="text-slate-500 italic">Belum ada disposisi.</div>
    @endforelse
</div>
