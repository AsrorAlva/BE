<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transportModel;
use \Illuminate\Support\Facades\Validator;

class TransportasiController extends Controller
{
    // Membaca semua data transportasi
    public function index(): \Illuminate\Http\JsonResponse
    {
        $transportasi = transportModel::all();
        return response()->json($transportasi);
    }

    //read perid
    public function show($id)
    {
        $transportasi = transportModel::findOrFail($id);
        return response()->json($transportasi);
    }

    // Membuat transportasi baru
    public function createTransport(Request $request): \Illuminate\Http\JsonResponse
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
            'jam_keberangkatan' => $request->jam_keberangkatan . ':00',
            'jam_kedatangan' => $request->jam_kedatangan . ':00',
            'kota' => $request->kota
        ]);

        // Jika transportasi berhasil dibuat, kembalikan respons berhasil
        if ($transportasi) {
            return response()->json(['message' => 'Transportasi berhasil dibuat', 'data' => $transportasi], 201);
        }

        // Jika terjadi kesalahan lain yang tidak diharapkan
        return response()->json(['message' => 'Terjadi kesalahan internal server'], 500);
    }

    // Mengupdate data transportasi
    public function update(Request $request, $id)
    {
        $transportasi = transportModel::find($id);

        if (!$transportasi) {
            return response()->json(['message' => 'Data hotel tidak ditemukan'], 404);
        }
        // Validasi data yang dikirim
        $validator = Validator::make($request->all(), [
            'nama_transportasi' => 'sometimes',
            'jenis_transportasi' => 'sometimes',
            'berangkat' => 'sometimes',
            'tujuan' => 'sometimes',
            'harga' => 'sometimes',
            'jam_keberangkatan' => 'sometimes',
            'jam_kedatangan' => 'sometimes',
            'kota' => 'sometimes'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Parameter tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        $transportasi->nama_transportasi = $request->nama_transportasi ?? $transportasi->nama_transportasi;
        $transportasi->jenis_transportasi = $request->jenis_transportasi ?? $transportasi->jenis_transportasi;
        $transportasi->berangkat = $request->berangkat ??  $transportasi->berangkat;
        $transportasi->tujuan = $request->tujuan ?? $transportasi->tujuan;
        $transportasi->harga = $request->harga ?? $transportasi->harga;
        $transportasi->jam_keberangkatan = $request->jam_keberangkatan ?? $transportasi->jam_keberangkatan;
        $transportasi->jam_kedatangan = $request->jam_kedatangan ?? $transportasi->jam_kedatangan;
        $transportasi->kota = $request->kota ?? $transportasi->kota;

        $transportasi->save();

        return response()->json([
            'message' => 'Transportasi berhasil diperbarui',
            'data' => $transportasi
        ], 200);
    }

    //delete transport
    public function deleteTransport($id)
    {
        // Cari data transportasi berdasarkan id
        $transportasi = transportModel::find($id);

        // Jika data transportasi tidak ditemukan, kembalikan respon not found
        if (!$transportasi) {
            return response()->json([
                'message' => 'Transportasi Tidak Ditemukan',
            ], 404);
        }

        // Hapus data transportasi
        $transportasi->delete();

        // Kembalikan respon berhasil
        return response()->json([
            'message' => 'Hapus Data Transportasi Berhasil',
        ], 200);
    }
}
