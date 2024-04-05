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
        Schema::create('transportasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_transportasi'); // Menyimpan nama pesawat atau nama bus
            $table->string('jenis_transportasi'); // Menyimpan jenis transportasi (pesawat atau bus)
            $table->string('berangkat');
            $table->string('tujuan');
            $table->decimal('harga', 10, 2);
            $table->time('jam_keberangkatan');
            $table->time('jam_kedatangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportasi');
    }
};
