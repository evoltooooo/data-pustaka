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
        Schema::create('buku', function (Blueprint $table) {
            $table->id('idBuku');
            $table->string('judul')->nullable();
            $table->string('penulis')->nullable();
            $table->string('penerbit')->nullable();
            $table->string('negara')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('jenis')->nullable();
            $table->string('genre')->nullable();
            $table->string('no_panggil')->nullable();
            $table->string('volume')->nullable();
            $table->string('halaman')->nullable();
            $table->string('bahasa')->nullable();
            $table->string('issn')->nullable();
            $table->string('tahun_terbit')->nullable();
            $table->string('cover')->nullable();
            $table->integer('stok')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
