<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disposisis', function (Blueprint $table) {
            // Kolom ini mencatat JENIS aksinya. Defaultnya adalah 'teruskan'.
            $table->string('tipe_aksi')->after('status')->default('teruskan');
        });
    }

    public function down(): void
    {
        Schema::table('disposisis', function (Blueprint $table) {
            $table->dropColumn('tipe_aksi');
        });
    }
};