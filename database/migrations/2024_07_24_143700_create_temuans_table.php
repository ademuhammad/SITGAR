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
        Schema::create('temuans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('informasis_id'); // Sumber informasi dari tabel informasi
            $table->unsignedBigInteger('opd_id'); // Nama OPD dari tabel opd
            $table->unsignedBigInteger('status_id'); // Status dari tabel status
            $table->unsignedBigInteger('statustgr_id')->nullable(); // Status dari tabel status tgr
            $table->unsignedBigInteger('pegawai_id'); // Nama PPK dari tabel pegawai
            $table->unsignedBigInteger('penyedia_id'); // Nama penyedia dari tabel penyedia
            $table->unsignedBigInteger('jenistemuan_id')->nullable();

            $table->string('no_lhp');
            $table->string('no_sktjm')->nullable();
            $table->string('no_skp2ks')->nullable();
            $table->string('no_skp2k')->nullable();

            $table->date('tgl_lhp');
            $table->text('obrik_pemeriksaan');
            $table->text('temuan');
            $table->text('rekomendasi');
            $table->decimal('nilai_rekomendasi', 15, 2);
            $table->string('bukti_surat')->nullable();
            $table->decimal('nilai_telah_dibayar', 15, 2)->default(0);
            $table->decimal('sisa_nilai_uang', 15, 2)->default(0);
            $table->integer('jumlah_jaminan')->nullable();
            // $table->text('jenis_jaminan')->nullable();


            // Define foreign keys
            $table->foreign('opd_id')->references('id')->on('opds')->onDelete('cascade');
            $table->foreign('informasis_id')->references('id')->on('informasis')->onDelete('cascade');
            $table->foreign('pegawai_id')->references('id')->on('pegawais')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->foreign('statustgr_id')->references('id')->on('statustgrs')->onDelete('cascade');
            $table->foreign('penyedia_id')->references('id')->on('penyedias')->onDelete('cascade');
            $table->foreign('jenistemuan_id')->references('id')->on('jenis_temuans')->onDelete('cascade');

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temuans');
    }
};
