<div class="w-full rounded-lg border shadow-sm bg-white border-slate-200 shadow-slate-950/5 max-w-[280px] h-screen">
    <a href="{{ auth()->check() && in_array(optional(auth()->user())->role->name, ['Super Admin', 'Admin']) ? route('surat.home') : route('inbox.index') }}"
        class="rounded m-2 mx-4 mt-4 h-max mb-4 flex flex-row gap-5 items-center">
        <img src="{{ asset('images/logo-lldikti.jpg') }}" alt="" class="h-10 w-auto">
        <p class="font-sans antialiased text-current text-2xl font-semibold">SIPADIS</p>
    </a>
    <hr class="-mx-3 border-slate-200" />

    <div>
        @include('components.layout.user')
    </div>
    <hr class="-mx-3 mt-3 border-slate-200" />
    <div class="w-full h-max rounded p-3">
        <ul class="flex flex-col gap-0.5 min-w-60">

            {{-- Pengecekan keamanan: pastikan user sudah login & punya peran --}}
            @if (auth()->check() && auth()->user()->role)


                @if (in_array(auth()->user()->role->name, ['Super Admin', 'Admin']))
                    <li>
                        <a href="{{ route('surat.home') }}"
                            class="flex items-center py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in aria-disabled:opacity-50 aria-disabled:pointer-events-none bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">
                            <span class="grid place-items-center shrink-0 me-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em"
                                    viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274"
                                        stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M15 18H9" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </span>
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('surat.tambah') }}"
                            class="flex items-center py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in aria-disabled:opacity-50 aria-disabled:pointer-events-none bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">
                            <span class="grid place-items-center shrink-0 me-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em"
                                    viewBox="0 0 24 24" fill="none">
                                    <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#1C274C"
                                        stroke-width="1.5" stroke-linecap="round" />
                                    <path
                                        d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8"
                                        stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </span>
                            Tambah Surat
                        </a>
                    </li>

                    <li>
                        <div data-toggle="collapse" data-target="#suratmasukcollapselist" aria-expanded="false"
                            aria-controls="sidebarCollapseList"
                            class="flex items-center justify-between min-w-60 cursor-pointer py-1.5 px-2.5 rounded-md align-middle transition-all duration-300 ease-in text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">
                            <span class="flex items-center gap-3">
                                <img src="{{ asset('images/email.png') }}" alt="" width="23px">
                                Surat Masuk
                            </span>
                            <span data-icon
                                class="grid place-items-center shrink-0 transition-transform duration-300 ease-in-out">
                                <svg width="1.5em" height="1.5em" stroke-width="1.5" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" color="currentColor"
                                    class="h-4 w-4 stroke-[1.5]">
                                    <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="overflow-hidden transition-[max-height] duration-300 ease-in-out max-h-0"
                            id="suratmasukcollapselist">
                            <ul class="flex flex-col gap-0.5 min-w-60">
                                <li>
                                    <a href="{{ route('outbox.index') }}"
                                        class="pl-10 flex items-center cursor-pointer py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">Terkirim</a>
                                </li>
                                <li>
                                    <a href="{{ route('surat.tanpaDisposisi') }}"
                                        class="pl-10 flex items-center cursor-pointer py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">Draft</a>
                                </li>
                                <li class="relative inline-flex">
                                    <a href="{{ route('inbox.ditolak') }}"
                                        class="pl-10 flex items-center cursor-pointer py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800 relative">

                                        <span class="flex items-center gap-2">
                                            Ditolak
                                            @if ($jumlahSuratDitolakBelumDilihat > 0)
                                                <span
                                                    class="grid min-h-[16px] min-w-[16px] place-items-center rounded-full border border-red-500 bg-red-500 px-1.5 text-xs leading-none text-white">
                                                    {{ $jumlahSuratDitolakBelumDilihat }}
                                                </span>
                                            @endif
                                        </span>
                                    </a>
                                </li>



                            </ul>
                        </div>
                    </li>


                    <li>
                        <div data-toggle="collapse" data-target="#agendasuratcollapselist" aria-expanded="false"
                            aria-controls="sidebarCollapseList"
                            class="flex items-center justify-between min-w-60 cursor-pointer py-1.5 px-2.5 rounded-md align-middle transition-all duration-300 ease-in text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">
                            <span class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="1.4em" height="1.4em" viewBox="0 0 17 17" version="1.1">
                                    <path
                                        d="M14 2v-2h-13v17h13v-2h2v-13h-2zM2 16v-15h2v15h-2zM13 16h-8v-15h8v15zM15 14h-1v-3h1v3zM15 10h-1v-3h1v3zM14 6v-3h1v3h-1zM6 4h5v1h-5v-1zM6 6h4v1h-4v-1z"
                                        fill="#000000" />
                                </svg>
                                Agenda Surat
                            </span>
                            <span data-icon
                                class="grid place-items-center shrink-0 transition-transform duration-300 ease-in-out">
                                <svg width="1.5em" height="1.5em" stroke-width="1.5" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" color="currentColor"
                                    class="h-4 w-4 stroke-[1.5]">
                                    <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="overflow-hidden transition-[max-height] duration-300 ease-in-out max-h-0"
                            id="agendasuratcollapselist">
                            <ul class="flex flex-col gap-0.5 min-w-60">
                                <li>
                                    <a href="{{ route('surat.agendaKbu') }}"
                                        class="pl-10 flex items-center cursor-pointer py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">KBU</a>
                                </li>
                                <li>
                                    <a href="{{ route('surat.agendaKepala') }}"
                                        class="pl-10 flex items-center cursor-pointer py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">Kepala
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a href="{{ route('surat.arsip') }}"
                            class="flex items-center py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in aria-disabled:opacity-50 aria-disabled:pointer-events-none bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">
                            <span class="grid place-items-center shrink-0 me-2.5">
                                <img src="{{ asset('images/inbox.png') }}" alt="" width="23px">
                            </span>
                            Arsip Surat
                        </a>
                    </li>

                    <hr class="-mx-3 my-3 border-slate-200" />
                    <li>
                        <div data-toggle="collapse" data-target="#organisasicollapselist" aria-expanded="false"
                            aria-controls="sidebarCollapseList"
                            class="flex items-center justify-between min-w-60 cursor-pointer py-1.5 px-2.5 rounded-md align-middle transition-all duration-300 ease-in text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">
                            <span class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em"
                                    viewBox="0 0 16 16" fill="#000000">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M9.111 4.663A2 2 0 1 1 6.89 1.337a2 2 0 0 1 2.222 3.326zm-.555-2.494A1 1 0 1 0 7.444 3.83a1 1 0 0 0 1.112-1.66zm2.61.03a1.494 1.494 0 0 1 1.895.188 1.513 1.513 0 0 1-.487 2.46 1.492 1.492 0 0 1-1.635-.326 1.512 1.512 0 0 1 .228-2.321zm.48 1.61a.499.499 0 1 0 .705-.708.509.509 0 0 0-.351-.15.499.499 0 0 0-.5.503.51.51 0 0 0 .146.356zM3.19 12.487H5v1.005H3.19a1.197 1.197 0 0 1-.842-.357 1.21 1.21 0 0 1-.348-.85v-1.81a.997.997 0 0 1-.71-.332A1.007 1.007 0 0 1 1 9.408V7.226c.003-.472.19-.923.52-1.258.329-.331.774-.52 1.24-.523H4.6a2.912 2.912 0 0 0-.55 1.006H2.76a.798.798 0 0 0-.54.232.777.777 0 0 0-.22.543v2.232h1v2.826a.202.202 0 0 0 .05.151.24.24 0 0 0 .14.05zm7.3-6.518a1.765 1.765 0 0 0-1.25-.523H6.76a1.765 1.765 0 0 0-1.24.523c-.33.335-.517.786-.52 1.258v3.178a1.06 1.06 0 0 0 .29.734 1 1 0 0 0 .71.332v2.323a1.202 1.202 0 0 0 .35.855c.18.168.407.277.65.312h2a1.15 1.15 0 0 0 1-1.167V11.47a.997.997 0 0 0 .71-.332 1.006 1.006 0 0 0 .29-.734V7.226a1.8 1.8 0 0 0-.51-1.258zM10 10.454H9v3.34a.202.202 0 0 1-.06.14.17.17 0 0 1-.14.06H7.19a.21.21 0 0 1-.2-.2v-3.34H6V7.226c0-.203.079-.398.22-.543a.798.798 0 0 1 .54-.232h2.48a.778.778 0 0 1 .705.48.748.748 0 0 1 .055.295v3.228zm2.81 3.037H11v-1.005h1.8a.24.24 0 0 0 .14-.05.2.2 0 0 0 .06-.152V9.458h1V7.226a.777.777 0 0 0-.22-.543.798.798 0 0 0-.54-.232h-1.29a2.91 2.91 0 0 0-.55-1.006h1.84a1.77 1.77 0 0 1 1.24.523c.33.335.517.786.52 1.258v2.182c0 .273-.103.535-.289.733-.186.199-.44.318-.711.333v1.81c0 .319-.125.624-.348.85a1.197 1.197 0 0 1-.842.357zM4 1.945a1.494 1.494 0 0 0-1.386.932A1.517 1.517 0 0 0 2.94 4.52 1.497 1.497 0 0 0 5.5 3.454c0-.4-.158-.784-.44-1.067A1.496 1.496 0 0 0 4 1.945zm0 2.012a.499.499 0 0 1-.5-.503.504.504 0 0 1 .5-.503.509.509 0 0 1 .5.503.504.504 0 0 1-.5.503z" />
                                </svg>
                                Organisasi
                            </span>
                            <span data-icon
                                class="grid place-items-center shrink-0 transition-transform duration-300 ease-in-out">
                                <svg width="1.5em" height="1.5em" stroke-width="1.5" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg" color="currentColor"
                                    class="h-4 w-4 stroke-[1.5]">
                                    <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="overflow-hidden transition-[max-height] duration-300 ease-in-out max-h-0"
                            id="organisasicollapselist">
                            <ul class="flex flex-col gap-0.5 min-w-60">
                                <li>
                                    <a href="{{ route('pegawai.index') }}"
                                        class="pl-10 flex items-center cursor-pointer py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">Pegawai</a>
                                </li>
                                <li>
                                    <a href="{{ route('timKerja.index') }}"
                                        class="pl-10 flex items-center cursor-pointer py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">Tim
                                        Kerja</a>
                                </li>
                                <li>
                                    <a href="{{ route('lembaga.index') }}"
                                        class="pl-10 flex items-center cursor-pointer py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">Lembaga</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
                {{-- AKHIR BLOK ADMIN --}}


                {{-- MENU BARU UNTUK NON-ADMIN --}}
                @if (in_array(auth()->user()->role->name, ['Kepala LLDIKTI', 'KBU', 'Katimja', 'Staf']))



                    <li>
                        <a href="{{ route('inbox.index') }}"
                            class="relative flex items-center py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">

                            <span class="grid place-items-center shrink-0 me-2.5 relative">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.12-1.588H6.88a2.25 2.25 0 00-2.12 1.588L2.35 13.177a2.25 2.25 0 00-.1.661z" />
                                </svg>

                                @if ($jumlahSuratInboxBelumDilihat > 0)
                                    <span
                                        class="absolute -top-2 -right-2 grid min-h-[16px] min-w-[16px] place-items-center rounded-full border border-red-500 bg-red-500 px-1.5 text-xs leading-none text-white">
                                        {{ $jumlahSuratInboxBelumDilihat }}
                                    </span>
                                @endif
                            </span>
                            Inbox
                        </a>
                    </li>



                    @if (!in_array(auth()->user()->role->name, ['Staf']))
                        <li>
                            <a href="{{ route('outbox.index') }}"
                                class="flex items-center py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">
                                <span class="grid place-items-center shrink-0 me-2.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.12-1.588H6.88a2.25 2.25 0 00-2.12 1.588L2.35 13.177a2.25 2.25 0 00-.1.661z" />
                                    </svg>
                                </span>
                                Terkirim
                            </a>
                        </li>
                        <li class="relative inline-flex">
                            <a href="{{ route('inbox.ditolak') }}"
                                class="flex items-center py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">

                                <span class="grid place-items-center shrink-0 me-2.5 relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" class="h-5 w-5"
                                        viewBox="0 -8 528 528">
                                        <path
                                            d="M264 56Q318 56 364 83 410 110 437 156 464 202 464 256 464 310 437 356 410 402 364 429 318 456 264 456 210 456 164 429 118 402 91 356 64 310 64 256 64 202 91 156 118 110 164 83 210 56 264 56ZM232 144L232 272 296 272 296 144 232 144ZM232 304L232 368 296 368 296 304 232 304Z" />
                                    </svg>

                                    {{-- Badge di pojok kanan atas ikon --}}
                                    @if ($jumlahSuratDitolakBelumDilihat > 0)
                                        <span
                                            class="absolute -top-2 -right-2 grid min-h-[16px] min-w-[16px] place-items-center rounded-full border border-red-500 bg-red-500 px-1.5 text-xs leading-none text-white">
                                            {{ $jumlahSuratDitolakBelumDilihat }}
                                        </span>
                                    @endif
                                </span>
                                Ditolak
                            </a>
                        </li>

                    @endif
                @endif
                <hr class="-mx-3 my-3 border-slate-200" />
                <li>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="flex items-center py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in aria-disabled:opacity-50 aria-disabled:pointer-events-none bg-transparent text-red-500 hover:bg-red-500/10 hover:text-error focus:bg-error/10 focus:text-error">
                            <span class="grid place-items-center shrink-0 me-2.5">
                                <svg width="1.5em" height="1.5em" stroke-width="1.5" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg" color="currentColor"
                                    class="h-[18px] w-[18px]">
                                    <path d="M12 12H19M19 12L16 15M19 12L16 9" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path
                                        d="M19 6V5C19 3.89543 18.1046 3 17 3H7C5.89543 3 5 3.89543 5 5V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V18"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </span>
                            Logout
                        </a>
                    </form>
                </li>
            @endif
        </ul>
    </div>
</div>
