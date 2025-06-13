<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Metode ini akan dieksekusi saat Anda menjalankan 'php artisan migrate'.
     */
    public function up(): void
    {
        Schema::table('divisis', function (Blueprint $table) {
            // Menambahkan kolom baru 'parent_role_id' setelah kolom 'nama_divisi'
            // Kolom ini akan terhubung ke tabel 'roles'.
            $table->foreignId('parent_role_id')
                  ->nullable() // Boleh kosong, karena tidak semua divisi punya atasan dalam hierarki ini
                  ->after('nama_divisi')
                  ->constrained('roles') // Membuat foreign key ke kolom 'id' di tabel 'roles'
                  ->onUpdate('cascade') // Jika ID di tabel roles berubah, di sini juga berubah
                  ->onDelete('set null'); // Jika role atasan dihapus, kolom ini menjadi NULL
        });
    }

    /**
     * Balikkan migrasi.
     * Metode ini akan dieksekusi saat Anda menjalankan 'php artisan migrate:rollback'.
     */
    public function down(): void
    {
        Schema::table('divisis', function (Blueprint $table) {
            // Drop foreign key constraint dulu sebelum drop kolom agar tidak error
            $table->dropForeign(['parent_role_id']);
            $table->dropColumn('parent_role_id');
        });
    }
};