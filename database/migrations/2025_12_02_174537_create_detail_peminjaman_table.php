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
        Schema::create('detail_peminjaman', function (Blueprint $table) {
            $table->id('idDetailPeminjaman');
            $table->unsignedBigInteger('idPeminjaman');
            $table->unsignedBigInteger('idBuku');
            $table->string('no_peminjaman');
            $table->timestamps();
            $table->foreign('idPeminjaman')->references('idPeminjaman')->on('peminjaman')->onDelete('cascade');
            $table->foreign('idBuku')->references('idBuku')->on('buku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_peminjaman');
    }
};
