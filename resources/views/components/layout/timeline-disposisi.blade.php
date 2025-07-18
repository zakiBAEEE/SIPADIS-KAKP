<div class="flex w-full flex-col items-center">
    @php
        $previousPenerimaId = null;
    @endphp

    @forelse ($disposisis as $index => $disposisi)
        {{-- Checkpoint: Pengirim --}}
        @if ($index === 0 || optional($disposisi->pengirim)->id !== $previousPenerimaId)
            <div class="group flex gap-x-6">
                <div class="relative">
                    <div class="absolute left-1/2 top-0 h-full w-0.5 -translate-x-1/2 bg-slate-200"></div>
                    <span
                        class="relative z-10 grid h-10 w-10 place-items-center rounded-full bg-slate-200 text-slate-800 text-xl">
                        📤
                    </span>
                </div>
                <div class="-translate-y-1.5 pb-8 text-slate-600">
                    <p class="font-sans text-base font-bold text-slate-800">{{ $disposisi->pengirim->name ?? '-' }}</p>
                    <small class="mt-2 font-sans text-sm text-slate-600">
                        Instruksi: {{ $disposisi->catatan ?? '-' }}<br>
                        Waktu: {{ \Carbon\Carbon::parse($disposisi->created_at)->translatedFormat('d F Y H:i') }}
                    </small>
                </div>
            </div>
        @endif

        {{-- Checkpoint: Penerima --}}
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

        <div class="group flex gap-x-6">
            <div class="relative">
                <div class="absolute left-1/2 top-0 h-full w-0.5 -translate-x-1/2 bg-slate-200"></div>
                <span
                    class="relative z-10 grid h-10 w-10 place-items-center rounded-full bg-slate-200 text-slate-800 text-xl">
                    {{ $icon }}
                </span>
            </div>
            <div class="-translate-y-1.5 pb-8 text-slate-600">
                @if ($disposisi->penerima && $disposisi->penerima->divisi)
                    <p class="text-sm font-medium">{{ $disposisi->penerima->name ?? 'N/A' }}
                    </p>
                    <p class="text-xs text-gray-500"> {{ $disposisi->penerima->divisi->nama_divisi }}
                        ({{ $disposisi->penerima->role->name }})
                    </p>
                @else
                    <p class="text-sm font-medium">{{ $disposisi->penerima->name ?? 'N/A' }}
                    </p>
                    <p class="text-xs text-gray-500">{{ $disposisi->penerima->role->name ?? '' }}</p>
                @endif
                <small class="mt-2 font-sans text-sm text-slate-600">
                    Status: {{ ucfirst($disposisi->status) ?? '-' }}
                </small>
            </div>
        </div>
    @empty
        <div class="text-slate-500 italic">Belum ada disposisi.</div>
    @endforelse
</div>
