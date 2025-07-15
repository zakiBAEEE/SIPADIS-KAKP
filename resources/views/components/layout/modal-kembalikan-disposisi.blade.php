
<div class="flex justify-center">
    
    <button type="button" data-toggle="modal" 
            data-target="#modalKembalikanDisposisi-{{ $disposisi->id }}" {{-- <- ID TARGET SEKARANG DINAMIS & BENAR --}}
            class="inline-flex border font-sans font-medium text-center transition-all duration-300 ease-in disabled:opacity-50 disabled:shadow-none disabled:cursor-not-allowed data-[shape=pill]:rounded-full data-[width=full]:w-full focus:shadow-none text-sm rounded-md py-1 px-2 shadow-sm hover:shadow bg-red-600 border-red-700 text-slate-50 hover:bg-red-700 hover:border-red-800">
        Kembalikan
    </button>

    {{-- MODAL YANG SESUAI DENGAN TOMBOL DI ATAS --}}
    <div class="fixed antialiased inset-0 bg-slate-900/60 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-300 ease-out z-[9999]"
         id="modalKembalikanDisposisi-{{ $disposisi->id }}" {{-- <- ID MODAL SEKARANG DINAMIS & BENAR --}}
         aria-hidden="true">
        
        {{-- Latar belakang untuk menutup modal saat diklik --}}
        <div class="fixed inset-0" data-dismiss="modal"></div>

        <div class="relative bg-white rounded-lg w-10/12 md:w-7/12 lg:w-5/12 transition-transform duration-300 ease-out scale-95 shadow-xl">
            <div class="px-6 py-4 flex justify-between items-center border-b border-gray-200">
                <h1 class="text-xl font-semibold text-gray-800">Kembalikan Disposisi</h1>
                <button type="button" data-dismiss="modal" aria-label="Close" class="p-1 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none">
                     <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form action="{{ route('disposisi.kembalikan', $disposisi->id) }}" method="POST">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label for="catatan_pengembalian-{{$disposisi->id}}" class="block text-sm font-medium text-gray-700 mb-1">
                            Alasan Pengembalian (Wajib Diisi)
                        </label>
                        <textarea name="catatan_pengembalian" id="catatan_pengembalian-{{$disposisi->id}}" rows="4"
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required
                                  placeholder="Tuliskan alasan mengapa disposisi ini dikembalikan..."></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 flex justify-end gap-x-3 bg-gray-50 border-t border-gray-200">
                    <button type="button" data-dismiss="modal" class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-red-700">Kirim Pengembalian</button>
                </div>
            </form>
        </div>
    </div>
</div>