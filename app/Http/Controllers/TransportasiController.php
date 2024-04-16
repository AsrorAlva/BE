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

    // Mengupdate data transportasi
    public function updateTransport(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        // Cari transportasi berdasarkan id yang dikirim
        $transportasi = transportModel::find($id);

        // Jika transportasi tidak ditemukan, kembalikan respons not found
        if (!$transportasi) {
            return response()->json(['message' => 'Transportasi tidak ditemukan'], 404);
        }

        // Validasi data yang diterima
        $validator = Validator::make($request->all(), [
            'nama_transportasi' => 'required|string',
            'jenis_transportasi' => 'required|string',
            'berangkat' => 'required|string',
            'tujuan' => 'required|string',
            'harga' => 'required|string',
            'jam_keberangkatan' => 'required|string',
            'jam_kedatangan' => 'required|string',
        ]);

        // Jika validasi gagal, kembalikan respons invalid parameter
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid Parameter',
                'errors' => $validator->errors()
            ], 422);
        }

        // Proses simpan data baru ke database
        try {
            // Mengupdate data transportasi
            $transportasi->update([
                'nama_transportasi' => $request->nama_transportasi,
                'jenis_transportasi' => $request->jenis_transportasi,
                'berangkat' => $request->berangkat,
                'tujuan' => $request->tujuan,
                'harga' => $request->harga,
                'jam_keberangkatan' => $request->jam_keberangkatan.':00',
                'jam_kedatangan' => $request->jam_kedatangan.':00'
            ]);

            // Kembalikan responsuccess dan data transportasi yang sudah diedit
            return response()->json([
                'message' => 'Data Transportasi Berhasil Diperbarui',
                'data' => $transportasi
            ], 200);
        } catch (\Exception $e) {
            // Kembalikan respon internal error jika terjadi error
            return response()->json([
                'message' => 'Internal Error',
                'error' => $e->getMessage()
            ], 500);
        }
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
