<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transportModel;
use Validator;

class TransportasiController extends Controller
{
    // Membaca semua data transportasi
    public function index()
    {
        $transportasi = transportModel::all();
        return response()->json($transportasi);
    }


    //createTranport

    public function createTransport(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_transportasi' => 'required|string',
            'jenis_transportasi' => 'required|string',
            'berangkat' => 'required|string',
            'tujuan' => 'required|string',
            'harga' => 'required|string',
            'jam_keberangkatan' => 'required|string',
            'jam_kedatangan' => 'required|string',
        ]);

        // Jika validasi gagal, kembalikan respons dengan status 422
        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $validator->errors()], 422);
        }

        // Buat transportasi baru berdasarkan data yang diterima
        $transportasi = transportModel::create([
            'nama_transportasi' => $request->nama_transportasi,
            'jenis_transportasi' => $request->jenis_transportasi,
            'berangkat' => $request->berangkat,
            'tujuan' => $request->tujuan,
            'harga' => $request->harga,
            'jam_keberangkatan' => $request->jam_keberangkatan.':00',
            'jam_kedatangan' => $request->jam_kedatangan.':00'
        ]);

        // Jika transportasi berhasil dibuat, kembalikan respons berhasil
        if ($transportasi) {
            return response()->json(['message' => 'Transportasi berhasil dibuat', 'data' => $transportasi], 201);
        }

        // Jika terjadi kesalahan lain yang tidak diharapkan
        return response()->json(['message' => 'Terjadi kesalahan internal server'], 500);
    }
    // Membaca berdasarkan jenis_transportasi
    // public function berdasarkanJenis($jenis)
    // {
    //     $transportasi = TransportModel::where('jenis_transportasi', $jenis)->get();

    //     if ($transportasi->isEmpty()) {
    //         // Jika tidak ada data yang ditemukan, kembalikan respons dengan pesan
    //         return response()->json(['message' => $jenis . ' tidak ada di dalam database'], 404);
    //     }

    //     // Jika data ditemukan, kembalikan data transportasi
    //     return response()->json($transportasi);
    // }

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
