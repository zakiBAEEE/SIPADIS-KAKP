<div class="flex justify-center">
    <button type="button" data-toggle="modal" data-target="#modalEditPegawai-{{ $id }}">

        @include('components.base.ikon-edit')

    </button>
    <div id="modalEditPegawai-{{ $id }}"
        class="fixed inset-0 z-[9999] bg-slate-950/50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-300 ease-out antialiased"
        aria-hidden="true">
        <div
            class="bg-white rounded-xl w-11/12 md:w-8/12 lg:w-5/12 shadow-lg transition-transform duration-300 ease-out scale-100 relative">

            {{-- Header --}}
            <div class="flex justify-between items-center px-6 pt-6 pb-4 border-b border-slate-200">
                <h1 class="text-xl font-semibold text-slate-800">Edit Tim Kerja</h1>
                <button type="button" data-dismiss="modal" aria-label="Close"
                    class="p-2 rounded-full hover:bg-slate-100 text-slate-600 hover:text-slate-800 transition absolute right-4 top-4">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 6.75l10.5 10.5m0-10.5L6.75 17.25" />
                    </svg>
                </button>
            </div>

            {{-- Form --}}
            <form action="{{ route('timKerja.update', $id) }}" method="POST">
                @csrf

                <div class="px-6 py-4 space-y-6">
                    {{-- Nama Tim Kerja --}}
                    <div>
                        @include('components.base.input-surat', [
                            'label' => 'Tim Kerja',
                            'placeholder' => 'Masukkan Tim Kerja',
                            'name' => 'nama_divisi',
                            'value' => $namaDivisi,
                        ])
                    </div>

                    {{-- Status Radio --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Status Tim Kerja</label>
                        <div class="flex gap-6">
                            <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                <input type="radio" name="is_active" value="1"
                                    class="text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                    {{ $isActive ? 'checked' : '' }}>
                                <span>Aktif</span>
                            </label>
                            <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                <input type="radio" name="is_active" value="0"
                                    class="text-indigo-600 focus:ring-indigo-500 border-gray-300"
                                    {{ !$isActive ? 'checked' : '' }}>
                                <span>Nonaktif</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 flex justify-end gap-3 border-t border-slate-200">
                    <button type="button" data-dismiss="modal"
                        class="px-4 py-2 rounded-md text-sm font-medium text-red-600 hover:bg-red-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 rounded-md text-sm font-medium text-white bg-slate-800 hover:bg-slate-700 transition shadow">
                        Edit
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
