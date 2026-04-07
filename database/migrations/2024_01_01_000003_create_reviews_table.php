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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('id_ulasan')->unique();
            $table->string('kategori_berita');
            $table->string('judul_berita');
            $table->integer('rating')->nullable();
            $table->string('nama_user')->nullable();
            $table->text('isi_ulasan_raw')->nullable();
            $table->text('isi_ulasan_clean')->nullable();
            $table->enum('sentimen', ['Positif', 'Netral', 'Negatif'])->nullable();
            $table->string('label_sentimen')->nullable();
            $table->dateTime('waktu_analisis')->nullable();
            $table->enum('status', ['pending', 'processed', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
