<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_agenda', 100);
            $table->string('nomor_surat', 100);
            $table->string('pengirim', 255);
            $table->date('tanggal_surat');
            $table->date('tanggal_terima');
            $table->string('perihal', 255);
            $table->string('klasifikasi_surat', 100)->nullable();
            $table->string('sifat', 100)->nullable(); // <--- Tambahan di sini
            $table->string('file_path')->nullable();
            $table->enum('status', ['draft', 'diverifikasi', 'diproses', 'diarsipkan'])->default('draft');
            $table->timestamps();
        });
    }
    
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuks');
    }
};
