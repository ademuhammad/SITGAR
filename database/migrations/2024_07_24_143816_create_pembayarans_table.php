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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('temuan_id'); // Referensi ke tabel temuans
            $table->decimal('jumlah_pembayaran', 15, 2); // Jumlah pembayaran (Rp)
            $table->date('tgl_pembayaran'); // Tanggal pembayaran
            $table->string('bukti_pembayaran')->nullable(); // Kolom bukti pembayaran untuk menyimpan file PDF jika diperlukan
            $table->string('status')->default('pending');

            // Define foreign key
            $table->foreign('temuan_id')->references('id')->on('temuans')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
