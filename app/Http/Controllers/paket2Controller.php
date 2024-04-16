<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\File;
use App\Models\paket2Model;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        'image' => 'nullable|array',
        'image.*' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
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
        $files = $request->file('image');
        $filenames = [];
        $path = 'uploads/';

        foreach ($files as $file) {
            $filename = time(). '.'. $file->getClientOriginalExtension();
            $file->move($path, $filename);
            $filenames[] = $filename;
        }

        $data['image'] = json_encode($filenames);
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
    public function read()
    {
        $paket = paket2Model::all();
        return response()->json($paket);
    }

    // //update
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
        if ($request->foto) {

            // Public storage
            $storage = Storage::disk('public');

            // Old foto delete
            if ($storage->exists($paket->foto))
                $storage->delete($paket->foto);

            // fotopath
            $fotoPath = Str::random(32) . "." . $request->foto->getClientOriginalExtension();
            $paket->foto = $fotoPath;

            // Image save in public folder
            $storage->put($fotoPath, file_get_contents($request->foto));
        }

        // Update data paket
        $paket->update($data);

        // Kirim respons berhasil
        return response()->json(['message' => 'Paket berhasil diperbarui', 'data' => $paket], 200);
    }



    public function show($id)
    {
        $paket = paket2Model::findOrFail($id);
        return response()->json($paket);
    }

    //read
    // public function read()
    // {
    //     $pakets = paket2Model::all();
    //     $pakets->each(function ($paket) {
    //         $paket->image = url($paket->image);
    //     });
    //     return response()->json($pakets);
    // }

    // public function show($id)
    // {
    //     $paket = paket2Model::findOrFail($id);
    //     $paket->image = url($paket->image);
    //     return response()->json($paket);
    // }

    // //updatecoba

    // public function edit(Request $request, $id)
    // {
    //     // Cari paket berdasarkan ID
    //     $paket =  paket2Model::findOrFail($id);

    //     // Kembalikan response berupa data paket yang akan diedit
    //     return response()->json(['message' => 'Data paket berhasil ditemukan', 'data' => $paket], 200);
    // }

    // public function update(Request $request, int $id)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'nama_paket' => 'required|string',
    //         'deskripsi' => 'required|string',
    //         'destinasi' => 'required|string',
    //         'transportasi' => 'required|string',
    //         'akomodasi' => 'required|string',
    //         'harga_paket' => 'required|string',
    //         'fasilitas' => 'required|string',
    //         'kuliner' => 'required|string',
    //         'image' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
    //         'rating' => 'required|string',
    //     ]);

    //     // Cari paket berdasarkan ID
    //     $paket = paket2Model::findOrFail($id);

    //     // Persiapkan data untuk disimpan ke dalam database
    //     $data = [
    //         'nama_paket' => $request->nama_paket,
    //         'deskripsi' => $request->deskripsi,
    //         'destinasi' => $request->destinasi,
    //         'transportasi' => $request->transportasi,
    //         'akomodasi' => $request->akomodasi,
    //         'harga_paket' => $request->harga_paket,
    //         'fasilitas' => $request->fasilitas,
    //         'kuliner' => $request->kuliner,
    //         'rating' => $request->rating,
    //     ];

    //     // Jika ada file gambar diunggah, simpan gambarnya dan tambahkan nama gambar ke data
    //     if ($request->hasFile('image')) {
    //         $file = $request->file('image');
    //         $filename = time() . '.' . $file->getClientOriginalExtension();
    //         $path = 'uploads/';
    //         $file->move($path, $filename);

    //         // Hapus gambar lama jika ada
    //         if (File::exists(public_path($paket->image))) {
    //             File::delete(public_path($paket->image));
    //         }

    //         // Simpan path gambar yang relatif terhadap direktori penyimpanan publik
    //         $data['image'] = $filename;
    //     }

    //     // Update data paket
    //     $paket->update($data);

    //     // Kirim respons berhasil
    //     return response()->json(['message' => 'Paket berhasil diperbarui', 'data' => $paket], 200);
    // }


    //calling paket for user
    public function paketForUser(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'tujuan' => 'required|string',
            'dari' => 'required|string',
            'berangkat' => 'required|date',
            'pulang' => 'required|date|after_or_equal:berangkat',
            'budget' => 'required|numeric',
        ]);

        // Jika validasi gagal, kembalikan respons dengan pesan kesalahan
        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $validator->errors()], 422);
        }

        // Ambil input dari request
        $tujuan = $request->tujuan;
        $dari = $request->dari;
        $berangkat = $request->berangkat;
        $pulang = $request->pulang;
        $budget = $request->budget;

        // Cari paket yang sesuai dengan kriteria
        $pakets = paket2Model::where('destinasi', $tujuan)
            ->where('harga_paket', '<=', $budget)
            ->get();

        // Filter paket berdasarkan tanggal keberangkatan dan tanggal pulang
        $filteredPakets = $pakets->filter(function ($paket) use ($berangkat, $pulang) {
            return ($paket->tanggal_keberangkatan >= $berangkat && $paket->tanggal_pulang <= $pulang);
        });

        // Kembalikan hasil pencarian dalam respons JSON
        return response()->json(['message' => 'Paket berhasil ditemukan', 'data' => $filteredPakets], 200);
    }
}
