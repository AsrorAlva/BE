<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\paket2Model;
use Validator;

class paket2Controller extends Controller
{
    //create data 
    public function create(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_paket' => 'required|string',
            'deskripsi' => 'required|string',
            'destinasi' => 'required|string',
            'transportasi' => 'required|string',
            'akomodasi' => 'required|string',
            'harga_paket' => 'required|string',
            'fasilitas' => 'required|string',
            'kuliner' => 'required|string',
            'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
            'rating' => 'required|string',
        ]);

        // Jika validasi gagal, kembalikan respons dengan pesan kesalahan
        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $validator->errors()], 422);
        }

        // Persiapkan data untuk disimpan ke dalam database
        $data = [
            'nama_paket' => $request->nama_paket,
            'deskripsi' => $request->deskripsi,
            'destinasi' => $request->destinasi,
            'transportasi' => $request->transportasi,
            'akomodasi' => $request->akomodasi,
            'harga_paket' => $request->harga_paket,
            'fasilitas' => $request->fasilitas,
            'kuliner' => $request->kuliner,
            'rating' => $request->rating,
        ];

        // Jika ada file gambar diunggah, simpan gambarnya dan tambahkan nama gambar ke data
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/paketIMG/';
            $file->move($path, $filename);
            $data['image'] = $path . $filename;
        }

        // Simpan data ke dalam database
        $paket = paket2Model::create($data);

        // Jika berhasil disimpan, kirim respons berhasil
        if ($paket) {
            return response()->json(['message' => 'Paket berhasil dibuat', 'data' => $paket], 201);
        }

        // Jika gagal menyimpan, kirim respons gagal
        return response()->json(['message' => 'Gagal membuat paket'], 500);
    }


    //read
    // public function read()
    // {
    //     $paket = paket2Model::all();
    //     return response()->json($paket);
    // }


    //update
    public function update(Request $request, $id)
    {
        // Cari paket berdasarkan ID
        $paket = paket2Model::find($id);

        // Jika paket tidak ditemukan, kirim respons error
        if (!$paket) {
            return response()->json(['message' => 'Paket tidak ditemukan'], 404);
        }

        // Persiapkan data untuk disimpan ke dalam database
        $data = [
            'nama_paket' => $request->nama_paket,
            'deskripsi' => $request->deskripsi,
            'destinasi' => $request->destinasi,
            'transportasi' => $request->transportasi,
            'akomodasi' => $request->akomodasi,
            'harga_paket' => $request->harga_paket,
            'fasilitas' => $request->fasilitas,
            'kuliner' => $request->kuliner,
            'rating' => $request->rating,
        ];

        // Jika ada file gambar diunggah, simpan gambarnya dan tambahkan nama gambar ke data
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/paketIMG/';
            $file->move($path, $filename);
            $data['image'] = $path . $filename;
        }

        // Update data paket
        $paket->update($data);

        // Kirim respons berhasil
        return response()->json(['message' => 'Paket berhasil diperbarui', 'data' => $paket], 200);
    }


    // public function show($id)
    // {
    //     $paket = paket2Model::findOrFail($id);
    //     return response()->json($paket);
    // }

    //read
    public function read()
    {
        $pakets = paket2Model::all();
        $pakets->each(function ($paket) {
            $paket->image = url($paket->image);
        });
        return response()->json($pakets);
    }

    public function show($id)
    {
        $paket = paket2Model::findOrFail($id);
        $paket->image = url($paket->image);
        return response()->json($paket);
    }
}
