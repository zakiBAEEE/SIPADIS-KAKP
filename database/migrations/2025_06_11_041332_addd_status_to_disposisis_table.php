<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disposisis', function (Blueprint $table) {
            // Menambahkan kolom status setelah kolom 'catatan'
            // Status default-nya adalah 'Terkirim'
            $table->string('status')->after('catatan')->default('Terkirim');
        });
    }

    public function down(): void
    {
        Schema::table('disposisis', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};