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
        Schema::create('badge_pencapaians', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pencapaian');
            $table->json('syarat'); // ini di model sudah di cast jadi array
            $table->foreignId('kategori_pencapaian_id')->constrained('kategori_pencapaians')->onDelete('cascade');
            $table->string('gambar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badge_pencapaians');
    }
};
