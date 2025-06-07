<div class="w-full rounded-lg border shadow-sm bg-white border-slate-200 shadow-slate-950/5 max-w-[280px] h-screen">
    <a href="{{ route('surat.home') }}" class="rounded m-2 mx-4 mt-4 h-max mb-4 flex flex-row gap-5 items-center">
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
            <li>
                <a href="{{ route('surat.home') }}"
                    class="flex items-center py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in aria-disabled:opacity-50 aria-disabled:pointer-events-none bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">
                    <span class="grid place-items-center shrink-0 me-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 24 24"
                            fill="none">
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 24 24"
                            fill="none">
                            <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#1C274C" stroke-width="1.5"
                                stroke-linecap="round" />
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 24 24"
                            fill="none">
                            <path
                                d="M18 6.00002V6.75002H18.75V6.00002H18ZM15.7172 2.32614L15.6111 1.58368L15.7172 2.32614ZM4.91959 3.86865L4.81353 3.12619H4.81353L4.91959 3.86865ZM5.07107 6.75002H18V5.25002H5.07107V6.75002ZM18.75 6.00002V4.30604H17.25V6.00002H18.75ZM15.6111 1.58368L4.81353 3.12619L5.02566 4.61111L15.8232 3.0686L15.6111 1.58368ZM4.81353 3.12619C3.91638 3.25435 3.25 4.0227 3.25 4.92895H4.75C4.75 4.76917 4.86749 4.63371 5.02566 4.61111L4.81353 3.12619ZM18.75 4.30604C18.75 2.63253 17.2678 1.34701 15.6111 1.58368L15.8232 3.0686C16.5763 2.96103 17.25 3.54535 17.25 4.30604H18.75ZM5.07107 5.25002C4.89375 5.25002 4.75 5.10627 4.75 4.92895H3.25C3.25 5.9347 4.06532 6.75002 5.07107 6.75002V5.25002Z"
                                fill="#1C274D" />
                            <path d="M8 12H16" stroke="#1C274D" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M8 15.5H13.5" stroke="#1C274D" stroke-width="1.5" stroke-linecap="round" />
                            <path
                                d="M4 6V19C4 20.6569 5.34315 22 7 22H17C18.6569 22 20 20.6569 20 19V14M4 6V5M4 6H17C18.6569 6 20 7.34315 20 9V10"
                                stroke="#1C274D" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        Surat Masuk
                    </span>

                    <span data-icon
                        class="grid place-items-center shrink-0 transition-transform duration-300 ease-in-out">
                        <svg width="1.5em" height="1.5em" stroke-width="1.5" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" color="currentColor" class="h-4 w-4 stroke-[1.5]">
                            <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </div>
                <div class="overflow-hidden transition-[max-height] duration-300 ease-in-out max-h-0"
                    id="suratmasukcollapselist">
                    <ul class="flex flex-col gap-0.5 min-w-60">
                        <li>
                            <a href="{{ route('surat.denganDisposisi') }}"
                                class="pl-10 flex items-center cursor-pointer py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">Terdisposisi</a>
                        </li>
                        <li>
                            <a href="{{ route('surat.tanpaDisposisi') }}"
                                class="pl-10 flex items-center cursor-pointer py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">Belum
                                Terdisposisi</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- ====================================================== --}}

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
                            xmlns="http://www.w3.org/2000/svg" color="currentColor" class="h-4 w-4 stroke-[1.5]">
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

            <hr class="-mx-3 my-3 border-slate-200" />
            <li>
                <div data-toggle="collapse" data-target="#organisasicollapselist" aria-expanded="false"
                    aria-controls="sidebarCollapseList"
                    class="flex items-center justify-between min-w-60 cursor-pointer py-1.5 px-2.5 rounded-md align-middle transition-all duration-300 ease-in text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">
                    <span class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.4em" height="1.4em" viewBox="0 0 16 16"
                            fill="#000000">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.111 4.663A2 2 0 1 1 6.89 1.337a2 2 0 0 1 2.222 3.326zm-.555-2.494A1 1 0 1 0 7.444 3.83a1 1 0 0 0 1.112-1.66zm2.61.03a1.494 1.494 0 0 1 1.895.188 1.513 1.513 0 0 1-.487 2.46 1.492 1.492 0 0 1-1.635-.326 1.512 1.512 0 0 1 .228-2.321zm.48 1.61a.499.499 0 1 0 .705-.708.509.509 0 0 0-.351-.15.499.499 0 0 0-.5.503.51.51 0 0 0 .146.356zM3.19 12.487H5v1.005H3.19a1.197 1.197 0 0 1-.842-.357 1.21 1.21 0 0 1-.348-.85v-1.81a.997.997 0 0 1-.71-.332A1.007 1.007 0 0 1 1 9.408V7.226c.003-.472.19-.923.52-1.258.329-.331.774-.52 1.24-.523H4.6a2.912 2.912 0 0 0-.55 1.006H2.76a.798.798 0 0 0-.54.232.777.777 0 0 0-.22.543v2.232h1v2.826a.202.202 0 0 0 .05.151.24.24 0 0 0 .14.05zm7.3-6.518a1.765 1.765 0 0 0-1.25-.523H6.76a1.765 1.765 0 0 0-1.24.523c-.33.335-.517.786-.52 1.258v3.178a1.06 1.06 0 0 0 .29.734 1 1 0 0 0 .71.332v2.323a1.202 1.202 0 0 0 .35.855c.18.168.407.277.65.312h2a1.15 1.15 0 0 0 1-1.167V11.47a.997.997 0 0 0 .71-.332 1.006 1.006 0 0 0 .29-.734V7.226a1.8 1.8 0 0 0-.51-1.258zM10 10.454H9v3.34a.202.202 0 0 1-.06.14.17.17 0 0 1-.14.06H7.19a.21.21 0 0 1-.2-.2v-3.34H6V7.226c0-.203.079-.398.22-.543a.798.798 0 0 1 .54-.232h2.48a.778.778 0 0 1 .705.48.748.748 0 0 1 .055.295v3.228zm2.81 3.037H11v-1.005h1.8a.24.24 0 0 0 .14-.05.2.2 0 0 0 .06-.152V9.458h1V7.226a.777.777 0 0 0-.22-.543.798.798 0 0 0-.54-.232h-1.29a2.91 2.91 0 0 0-.55-1.006h1.84a1.77 1.77 0 0 1 1.24.523c.33.335.517.786.52 1.258v2.182c0 .273-.103.535-.289.733-.186.199-.44.318-.711.333v1.81c0 .319-.125.624-.348.85a1.197 1.197 0 0 1-.842.357zM4 1.945a1.494 1.494 0 0 0-1.386.932A1.517 1.517 0 0 0 2.94 4.52 1.497 1.497 0 0 0 5.5 3.454c0-.4-.158-.784-.44-1.067A1.496 1.496 0 0 0 4 1.945zm0 2.012a.499.499 0 0 1-.5-.503.504.504 0 0 1 .5-.503.509.509 0 0 1 .5.503.504.504 0 0 1-.5.503z" />
                        </svg>
                        Organisasi
                    </span>

                    <span data-icon
                        class="grid place-items-center shrink-0 transition-transform duration-300 ease-in-out">
                        <svg width="1.5em" height="1.5em" stroke-width="1.5" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" color="currentColor" class="h-4 w-4 stroke-[1.5]">
                            <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </svg>
                    </span>
                </div>
                <div class="overflow-hidden transition-[max-height] duration-300 ease-in-out max-h-0"
                    id="organisasicollapselist">
                    <ul class="flex flex-col gap-0.5 min-w-60">
                        <li>
                            <a href="/pegawai"
                                class="pl-10 flex items-center cursor-pointer py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">Pegawai</a>
                        </li>
                        <li>
                            <a href="/tim-kerja"
                                class="pl-10 flex items-center cursor-pointer py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">Tim
                                Kerja</a>
                        </li>
                        <li>
                            <a href="/lembaga"
                                class="pl-10 flex items-center cursor-pointer py-1.5 px-2.5 rounded-md align-middle select-none font-sans transition-all duration-300 ease-in bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-200 focus:bg-slate-200 focus:text-slate-800">Lembaga</a>
                        </li>
                    </ul>
                </div>
            </li>
            <hr class="-mx-3 my-3 border-slate-200" />
            <li>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf {{-- Token CSRF untuk keamanan, wajib untuk request POST --}}
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                        {{-- Mencegah aksi default link & submit form --}}
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
        </ul>
    </div>
</div>
