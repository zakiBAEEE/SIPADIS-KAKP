<div class="flex justify-center">
    <button type="button" data-toggle="modal" data-target="#modalTambahPegawai"
        class="inline-flex items-center border font-medium text-sm px-4 py-2 rounded-md shadow-sm bg-green-500 text-white hover:bg-green-700 transition">
        Tambah Pegawai
    </button>

    <div id="modalTambahPegawai"
        class="fixed inset-0 z-[9999] bg-slate-900/60 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 ease-out"
        aria-hidden="true">
        <div
            class="bg-white rounded-lg w-full max-w-xl mx-4 sm:mx-0 max-h-[90vh] overflow-y-auto shadow-lg transform transition-all">
            <div class="p-4 border-b flex justify-between items-center sticky top-0 bg-white z-10">
                <h2 class="text-lg font-semibold text-slate-800">Tambah Pegawai</h2>
                <button type="button" data-dismiss="modal" aria-label="Close"
                    class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>


            <form action="{{ route('pegawai.store') }}" method="POST">
                @csrf
                {{-- Tampilkan error umum dari session --}}
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="p-6 space-y-4">
                    {{-- Nama --}}
                    <div>
                        <label for="tambah_name" class="block text-sm font-medium text-gray-700 mb-1">Nama
                            Lengkap</label>
                        <input type="text" name="name" id="tambah_name"
                            class="w-full h-10 px-3 rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Username --}}
                    <div>
                        <label for="tambah_username" class="block text-sm font-medium text-gray-700 mb-1">Username
                            (NIP/ID)</label>
                        <input type="text" name="username" id="tambah_username"
                            class="w-full h-10 px-3 rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            value="{{ old('username') }}" required>
                        @error('username')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Peran dan Divisi --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tambah_role_id" class="block text-sm font-medium text-gray-700 mb-1">Peran
                                (Role)</label>
                            <select name="role_id" id="tambah_role_id"
                                class="w-full h-10 px-3 rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                required>
                                <option value="">-- Pilih Peran --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" data-role-name="{{ $role->name }}"
                                        {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tambah_divisi_id" class="block text-sm font-medium text-gray-700 mb-1">Divisi
                                (Opsional)</label>
                            <select name="divisi_id" id="tambah_divisi_id"
                                class="w-full h-10 px-3 rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm 
                    disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed"
                                {{ old('role_id') !== 'Katimja' ? 'disabled' : '' }}>
                                <option value="">-- Pilih Divisi --</option>
                                @foreach ($divisis as $divisi)
                                    @if ($divisi->is_active)
                                        <option value="{{ $divisi->id }}"
                                            {{ old('divisi_id') == $divisi->id ? 'selected' : '' }}>
                                            {{ $divisi->nama_divisi }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('divisi_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tambah_password"
                                class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" id="tambah_password"
                                class="w-full h-10 px-3 rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                required>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tambah_password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="tambah_password_confirmation"
                                class="w-full h-10 px-3 rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                required>
                        </div>
                    </div>
                </div>
                {{-- Tombol --}}
                <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-3">
                    <button type="button" data-dismiss="modal"
                        class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700 shadow">
                        Tambah Pegawai
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
