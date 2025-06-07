{{-- File: resources/views/components/modals/edit-disposisi.blade.php --}}

<div id="modalEditDisposisi"
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/60 opacity-0 pointer-events-none transition-opacity duration-300 ease-out"
    aria-hidden="true" role="dialog" aria-modal="true">

    {{-- Klik luar untuk tutup --}}
    <div class="fixed inset-0 cursor-pointer" data-dismiss="modal"></div>

    {{-- Konten Modal --}}
    <div
        class="relative w-11/12 md:w-8/12 lg:w-5/12 bg-white rounded-2xl shadow-2xl transform scale-95 transition-all duration-300 ease-out">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Edit Disposisi</h2>
            <button type="button" data-dismiss="modal" aria-label="Close"
                class="p-1.5 rounded-full text-gray-400 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form id="formEditDisposisi" method="POST" action="">
            @csrf
            @method('PUT')

            {{-- Body --}}
            <div class="px-6 py-6 space-y-6">
                {{-- Baris Tanggal dan Tujuan --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="edit_tanggal_disposisi"
                            class="block text-sm font-medium text-gray-700 mb-1">Tanggal Disposisi</label>
                        <input type="date" id="edit_tanggal_disposisi" name="tanggal_disposisi"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    </div>
                    <div>
                        <label for="edit_ke_user_id"
                            class="block text-sm font-medium text-gray-700 mb-1">Tujuan Disposisi</label>
                        <select id="edit_ke_user_id" name="ke_user_id"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm bg-white">
                            @foreach ($users as $user)
                                <option value="{{ $user['value'] }}">{{ $user['display'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Instruksi / Catatan --}}
                <div>
                    <label for="edit_catatan"
                        class="block text-sm font-medium text-gray-700 mb-1">Instruksi / Catatan</label>
                    <textarea id="edit_catatan" name="catatan" rows="4"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm resize-none"></textarea>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex justify-end px-6 py-4 bg-gray-50 border-t border-gray-200 gap-3">
                <button type="button" data-dismiss="modal"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
