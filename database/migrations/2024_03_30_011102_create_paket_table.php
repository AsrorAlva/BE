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
        Schema::create('paket', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->text('deskripsi');
            $table->decimal('harga_paket', 10, 2);
            $table->date('tanggal_berangkat');
            $table->date('tanggal_pulang');
            $table->integer('durasi'); // dalam hari
            $table->string('lokasi_berangkat');
            $table->string('lokasi_tujuan');
            // tambahkan kolom-kolom lain sesuai kebutuhan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket');
    }
};
