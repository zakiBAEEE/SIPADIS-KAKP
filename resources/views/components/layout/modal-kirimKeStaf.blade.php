<div class="flex justify-center">
    <button type="button" data-toggle="modal" data-target="#modalKirimKeStaf"
        class="inline-flex border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-green-500 border-slate-300 text-slate-50 hover:bg-green-700 hover:border-slate-700">
        Disposisikan Ke Staff</button>
    <div class="fixed antialiased inset-0 bg-slate-950/50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-300 ease-out z-[9999]"
        id="modalKirimKeStaf" aria-hidden="true">
        <div
            class="bg-white rounded-lg w-10/12 md:w-8/12 lg:w-6/12 transition-transform duration-300 ease-out scale-100">
            <div class="p-4 pb-2 flex justify-between items-center">
                <h1 class="text-lg text-slate-800 font-semibold">Disposisikan ke Staf</h1>
                <button type="button" data-dismiss="modal" aria-label="Close"
                    class="inline-grid place-items-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none data-[shape=circular]:rounded-full text-sm min-w-[34px] min-h-[34px] rounded-md bg-transparent border-transparent text-slate-200-foreground hover:bg-slate-200/10 hover:border-slate-200/10 shadow-none hover:shadow-none outline-none absolute right-2 top-2">
                    <svg width="1.5em" height="1.5em" stroke-width="1.5" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg" color="currentColor" class="h-5 w-5">
                        <path
                            d="M6.75827 17.2426L12.0009 12M17.2435 6.75736L12.0009 12M12.0009 12L6.75827 6.75736M12.0009 12L17.2435 17.2426"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('disposisi.disposisiSemuaStaf', $surat->id) }}" method="POST">
                @csrf
                <div class="p-4 flex flex-col gap-2">
                    <div>
                        @include('components.base.input-surat', [
                            'label' => 'Catatan untuk Staf',
                            'placeholder' => 'Tambahkan Catatan',
                            'name' => 'catatan',
                        ])
                    </div>
                    @php
                        $user = Auth::user();

                        $stafs = \App\Models\User::where('divisi_id', $user->divisi_id)
                            ->whereHas('role', fn($q) => $q->where('name', 'Staf'))
                            ->get();
                    @endphp

                    @if ($stafs->count())
                        <div class="p-4 pt-0">
                            <p class="text-sm font-semibold text-slate-700 mb-2">Daftar Staf di Divisi Ini:</p>
                            <ul class="list-disc pl-6 text-sm text-slate-600 space-y-1">
                                @foreach ($stafs as $staf)
                                    <li>{{ $staf->name }} ({{ $staf->email }})</li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                      
                    <div class="p-4 pt-0">
                        <p class="text-sm text-red-600">Tidak ada staf terdaftar di divisi ini.</p>
                    </div>
                    @endif

                </div>
                <div class="p-4 flex justify-end gap-2">
                    <button type="button" data-dismiss="modal"
                        class="inline-flex items-center justify-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-2 px-4 bg-transparent border-transparent text-red-500 hover:bg-red-500/10 hover:border-red-500/10 shadow-none hover:shadow-none outline-none">Batal</button>
                    <button type="submit"
                        class="inline-flex items-center justify-center border align-middle select-none font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-2 px-4 shadow-sm hover:shadow-md bg-slate-800 border-slate-800 text-slate-50 hover:bg-slate-700 hover:border-slate-700">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
