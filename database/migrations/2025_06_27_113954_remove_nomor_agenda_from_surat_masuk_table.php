<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveNomorAgendaFromSuratMasukTable extends Migration
{
    /**
     * Jalankan migrasi: hapus kolom nomor_agenda dari surat_masuk.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->dropColumn('nomor_agenda');
        });
    }

    /**
     * Rollback migrasi: tambahkan kembali kolom nomor_agenda.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->string('nomor_agenda')->nullable();
        });
    }
}
