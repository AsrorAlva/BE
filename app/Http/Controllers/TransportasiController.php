<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transportModel;

class TransportasiController extends Controller
{
    // Membaca semua data transportasi
    public function index()
    {
        $transportasi = transportModel::all();
        return response()->json($transportasi);
    }

    // Membaca berdasarkan jenis_transportasi
    public function berdasarkanJenis($jenis)
    {
        $transportasi = TransportModel::where('jenis_transportasi', $jenis)->get();

        if ($transportasi->isEmpty()) {
            // Jika tidak ada data yang ditemukan, kembalikan respons dengan pesan
            return response()->json(['message' => $jenis . ' tidak ada di dalam database'], 404);
        }

        // Jika data ditemukan, kembalikan data transportasi
        return response()->json($transportasi);
    }

    //berdasarkan harga
    // public function harga(Request $request, $harga)
    // {
    //     // Membersihkan string harga dari karakter non-angka
    //     $hargaNumerik = preg_replace('/[^0-9]/', '', $harga);

    //     // Mengonversi harga numerik menjadi float
    //     $hargaNumerik = (float) $hargaNumerik;

    //     // Mencari transportasi dengan harga di bawah nilai yang diberikan
    //     $transportasi = transportModel::where('harga', '<', $hargaNumerik)->get();

    //     if ($transportasi->isEmpty()) {
    //         // Jika tidak ada data yang ditemukan, kembalikan respons dengan pesan
    //         return response()->json(['message' => 'Tidak ada data transportasi dengan harga kurang dari IDR ' . number_format($hargaNumerik, 2, ',', '.')], 404);
    //     }

    //     // Jika data ditemukan, kembalikan data transportasi
    //     return response()->json($transportasi);
    // }
}
