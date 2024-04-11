<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\paketModel;

class paketController extends Controller
{
    //membuat paket

    public function buatpaket(Request $request)
    {
        //validasi paketnya
        $validatedData = $request->validate([
            'nama_paket' => 'required|string',
            'deskripsi' => 'required|string',
            'harga_paket' => 'required|numeric',
            'tanggal_berangkat' => 'required|date',
            'tanggal_pulang' => 'required|date',
            'durasi' => 'required|integer',
            'lokasi_berangkat' => 'required|string',
            'lokasi_tujuan' => 'required|string',
            'id_hotels' => 'required|exists:hotels,id_hotels',
            'id_transportasi' => 'required|exists:transportasi,id_transportasi',
            'id_destinasi' => 'required|exists:destinasi,id_destinasi',
        ]);

        // Simpan data paket baru ke dalam database
        $paket = PaketModel::create($validatedData);

        // Response dengan data paket yang baru saja dibuat
        return response()->json(['message' => 'Paket berhasil dibuat', 'data' => $paket], 201);

    }
}
