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
    Schema::create('disposisis', function (Blueprint $table) {
    $table->id();
    $table->foreignId('surat_id')->constrained('surat_masuk');
    $table->foreignId('dari_user_id')->constrained('users');
    $table->foreignId('ke_user_id')->constrained('users');
    $table->text('catatan')->nullable();
    $table->timestamp('tanggal_disposisi'); // Admin input manual tanggal disposisi
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('disposisis');
    }
};
