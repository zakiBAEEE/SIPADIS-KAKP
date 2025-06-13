{{-- Komponen ini menerima satu variabel: $disposisi (disposisi yang aktif) --}}
<div class="fixed antialiased inset-0 bg-slate-900/60 flex justify-center items-center opacity-0 pointer-events-none ..."
    id="modalKembalikanDisposisi-{{ $disposisi->id }}" aria-hidden="true">
    <div class="relative bg-white rounded-lg w-10/12 md:w-7/12 lg:w-5/12 ...">
        <div class="px-6 py-4 flex justify-between items-center border-b">
            <h1 class="text-xl font-semibold text-gray-800">Kembalikan Disposisi</h1>
            <button type="button" data-dismiss="modal" class="...">X</button>
        </div>
        <form action="{{ route('disposisi.kembalikan', $disposisi->id) }}" method="POST">
            @csrf
            <div class="p-6 space-y-4">
                <div>
                    <label for="catatan_pengembalian" class="block text-sm font-medium text-gray-700 mb-1">
                        Alasan Pengembalian / Catatan (Wajib Diisi)
                    </label>
                    <textarea name="catatan_pengembalian" id="catatan_pengembalian" rows="4"
                        class="block w-full rounded-md border-gray-300 ..." required
                        placeholder="Tuliskan alasan mengapa disposisi ini dikembalikan..."></textarea>
                </div>
            </div>
            <div class="px-6 py-4 flex justify-end gap-x-3 bg-gray-50 border-t">
                <button type="button" data-dismiss="modal" class="...">Batal</button>
                <button type="submit" class="bg-red-600 ... text-white ...">Kirim Pengembalian</button>
            </div>
        </form>
    </div>
</div>
