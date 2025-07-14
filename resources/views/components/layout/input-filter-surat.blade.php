<div class="px-4">
    <div class="mb-4 w-full">

    </div>
    <div class="flex flex-col md:flex-row gap-3">
        <div class="mb-4 space-y-1.5 md:w-1/2 w-full">
            @include('components.base.input-surat', [
                'label' => 'Nomor Surat',
                'placeholder' => 'Masukkan Nomor Surat',
                'name' => 'nomor_surat',
                'value' => request('nomor_surat'),
            ])
        </div>
        <div class="flex flex-col sm:flex-row flex-1">
            <div class="mb-4 space-y-1.5 md:w-1/2 w-full">
                @include('components.base.datepicker', [
                    'label' => 'Tanggal Surat',
                    'placeholder' => 'Pilih Tanggal Surat',
                    'id' => 'filter_tanggal_surat',
                    'name' => 'filter_tanggal_surat',
                    'value' => request('filter_tanggal_surat'),
                ])
            </div>
            <div class="mb-4 space-y-1.5 md:w-1/2 w-full">
                @include('components.base.datepicker', [
                    'label' => 'Tanggal Terima',
                    'placeholder' => 'Pilih Tanggal Terima',
                    'id' => 'filter_created_at',
                    'name' => 'filter_created_at',
                    'value' => request('filter_created_at'),
                ])
            </div>
        </div>
    </div>
    <div class="flex flex-col md:flex-row gap-3 items-center">
        <div class="mb-4 space-y-1.5 md:w-1/2 w-full">
            @include('components.base.input-surat', [
                'label' => 'Pengirim',
                'placeholder' => 'Masukkan Pengirim Surat',
                'name' => 'pengirim',
                'value' => request('pengirim'),
            ])
        </div>
        <div class="flex flex-col sm:flex-row w-full">
            <div class="mb-4 space-y-1.5 md:w-1/2 w-full ">
                @include('components.base.dropdown', [
                    'label' => 'Klasifikasi',
                    'value' => ['Umum', 'Pengaduan', 'Permintaan Informasi'],
                    'name' => 'klasifikasi_surat',
                    'selected' => request('klasifikasi_surat'),
                ])
            </div>
            <div class="mb-4 space-y-1.5 md:w-1/2 w-full">
                @include('components.base.dropdown', [
                    'label' => 'Sifat',
                    'value' => ['Rahasia', 'Penting', 'Segera', 'Rutin'],
                    'name' => 'sifat',
                    'selected' => request('sifat'),
                ])
            </div>
        </div>
    </div>
    <div class="space-y-1.5 mb-4">
        @include('components.base.input-surat', [
            'label' => 'Perihal',
            'placeholder' => 'Masukkan Perihal Surat',
            'name' => 'perihal',
            'value' => request('perihal'),
        ])
    </div>
