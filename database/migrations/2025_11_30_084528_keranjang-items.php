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
        if (!Schema::hasTable('keranjang_items')){
        Schema::create('keranjang_items', function (Blueprint $table) {
            $table->id('idCartItem');
            $table->unsignedBigInteger('idCart');
            $table->unsignedBigInteger('idBuku');
            $table->timestamps();

            $table->foreign('idCart')->references('idCart')->on('keranjang')->onDelete('cascade');
            $table->foreign('idBuku')->references('idBuku')->on('buku')->onDelete('cascade');
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang_items');
    }
};
