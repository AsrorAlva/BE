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
        Schema::create('paket2', function (Blueprint $table) {
            $table->id(); // id_paket, auto increment
            $table->string('nama_paket', 255);
            $table->string('deskripsi', 255);
            $table->string('destinasi', 255);
            $table->string('transportasi', 255);
            $table->string('akomodasi', 255);
            $table->string('harga_paket', 255);
            $table->string('fasilitas', 255);
            $table->string('kuliner', 255);
            $table->string('rating', 50);
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket2');
    }
};
