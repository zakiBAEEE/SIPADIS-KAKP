<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            // Jadikan 'id' sebagai string karena akan di-generate manual
            $table->string('id')->primary();

            $table->string('nomor_surat', 100)->unique();
            $table->string('pengirim', 255);

            // Kolom tambahan hasil gabungan migration
            $table->string('asal_instansi')->nullable();
            $table->string('email_pengirim')->nullable();

            $table->date('tanggal_surat');
            $table->string('perihal', 255);
            $table->string('klasifikasi_surat', 100)->nullable();
            $table->string('sifat', 100)->nullable();
            $table->string('file_path')->nullable();

            $table->enum('status', [
                'draft',
                'diproses',
                'selesai',
                'ditolak',
                'ditindaklanjuti'
            ])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
