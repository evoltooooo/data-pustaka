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
        Schema::create('buku_user_ratings', function (Blueprint $table) {
            $table->id('idRating');
            $table->foreignId('idUser')->references('idUser')->on('users')->cascadeOnDelete();
            $table->foreignId('idBuku')->references('idBuku')->on('buku')->cascadeOnDelete();
            $table->tinyInteger('rating'); 
            $table->timestamps();

            $table->unique(['idUser', 'idBuku']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_user_ratings');
    }
};
