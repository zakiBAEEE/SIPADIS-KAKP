 <div class="px-4 py-2">
     <div class="mb-4 space-y-1.5 w-full">

     </div>
     <div class="flex md:flex-row gap-3 flex-col">
         <div class="mb-4 space-y-1.5 md:w-1/2 w-full">
             @include('components.base.input-surat', [
                 'label' => 'Nomor Surat (Sebaiknya Bersifat Unik)',
                 'placeholder' => 'Masukkan Nomor Surat',
                 'name' => 'nomor_surat',
             ])
         </div>
         <div class="mb-4 space-y-1.5  md:w-1/2 w-full">
             @include('components.base.datepicker', [
                 'label' => 'Tanggal Surat',
                 'placeholder' => 'Pilih Tanggal Surat',
                 'id' => 'tanggal_surat',
                 'name' => 'tanggal_surat',
             ])
         </div>
     </div>
     <div class="flex md:flex-row gap-3 flex-col">
         <div class="mb-4 space-y-1.5 md:w-1/2 w-full">
             @include('components.base.input-surat', [
                 'label' => 'Asal Instansi',
                 'placeholder' => 'Masukkan Asal Instansi Surat',
                 'name' => 'asal_instansi',
             ])
         </div>
         <div class="mb-4 space-y-1.5  md:w-1/2 w-full">
             @include('components.base.input-email', [
                 'label' => 'Email Pengirim',
                 'placeholder' => 'Masukkan Email Pengirim',
                 'name' => 'email_pengirim',
             ])
         </div>
     </div>
     <div class="flex flex-col gap-3 items-center md:flex-row">
         <div class="mb-4 space-y-1.5 md:w-1/2 w-full">
             @include('components.base.input-surat', [
                 'label' => 'Pengirim',
                 'placeholder' => 'Masukkan Nama Pengirim Surat',
                 'name' => 'pengirim',
             ])
         </div>
         <div class="flex sm:flex-row flex-col justify-evenly items-center w-full flex-1">
             <div class="mb-4 space-y-1.5 md:w-1/2 w-full flex-1">
                 @include('components.base.dropdown', [
                     'label' => 'Klasifikasi',
                     'value' => ['Umum', 'Pengaduan', 'Permintaan Informasi'],
                     'name' => 'klasifikasi_surat',
                 ])
             </div>
             <div class="mb-4 space-y-1.5 md:w-1/2 w-full flex-1">
                 @include('components.base.dropdown', [
                     'label' => 'Sifat',
                     'value' => ['Rahasia', 'Penting', 'Segera', 'Rutin'],
                     'name' => 'sifat',
                 ])
             </div>
         </div>
     </div>
     <div class="space-y-1.5 mb-4">
         @include('components.base.input-surat', [
             'label' => 'Perihal',
             'placeholder' => 'Masukkan Perihal Surat',
             'name' => 'perihal',
         ])
     </div>
 </div>
