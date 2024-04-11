<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Hotel;
use Validator;


class hotelsController extends Controller
{
    //read data for paket
    public function index()
    {
        $hotel = Hotel::all();
        return response()->json($hotel);
    }
    

    //hotelsCreate
    public function createHotel(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_hotel' => 'required|string',
            'kota' => 'required|string',
            'alamat' => 'required|string',
            'harga' => 'required|string',
            'rating' => 'required|string',
            'gambar' => 'required|url',
        ]);

        // Jika validasi gagal, kembalikan respons dengan status 422
        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $validator->errors()], 422);
        }

        // Buat hotel baru berdasarkan data yang diterima
        $hotel = Hotel::create([
            'nama_hotel' => $request->nama_hotel,
            'kota' => $request->kota,
            'alamat' => $request->alamat,
            'harga' => $request->harga,
            'rating' => $request->rating,
            'gambar' => $request->gambar,
        ]);

        // Jika hotel berhasil dibuat, kembalikan respons berhasil
        if ($hotel) {
            return response()->json(['message' => 'Hotel berhasil dibuat', 'data' => $hotel], 201);
        }

        // Jika terjadi kesalahan lain yang tidak diharapkan
        return response()->json(['message' => 'Terjadi kesalahan internal server'], 500);
    }
}
