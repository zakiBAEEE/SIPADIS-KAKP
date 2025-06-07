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
       Schema::create('lembaga', function (Blueprint $table) {
    $table->id();
    $table->string('nama_kementerian');
    $table->string('nama_lembaga');
    $table->string('email');
    $table->string('alamat');
    $table->string('telepon');
    $table->string('website')->nullable();
    $table->string('kota');
    $table->string('provinsi');
    $table->string('kepala_kantor');
    $table->string('nip_kepala_kantor');
    $table->string('jabatan');
    $table->string('logo')->nullable();
    $table->year('tahun');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lembagas');
    }
};
