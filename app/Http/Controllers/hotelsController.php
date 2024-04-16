<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Hotel;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Support\Facades\Validator;


class hotelsController extends Controller
{
    //read data for paket
    public function index()
    {
        $hotel = Hotel::all();
        return response()->json($hotel);
    }


    //hotelsCreate upload banyak gambar
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_hotel' => 'required|string',
                'kota' => 'required|string',
                'alamat' => 'required|string',
                'harga' => 'required|string',
                'rating' => 'required|string',
            ]
        )->validate();

        foreach ($request->gambar as $image) {
            $imgName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imgName);
            $data[] = $imgName;
        }

        $hotel = new Hotel;
        $hotel->nama_hotel = $request->nama_hotel;
        $hotel->kota = $request->kota;
        $hotel->alamat = $request->alamat;
        $hotel->harga = $request->harga;
        $hotel->rating = $request->rating;
        $hotel->gambar = json_encode($data);
        $hotel->save();

        return response()->json([
            "message" => "Hotel Berhasil Ditambahkan!"
        ], 201);
    }

    //show detail hotel by id
    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);
        return response()->json($hotel);
    }


    //update data hotel by id
    public function update(Request $request, $id)
    {
        $rules = [
            'nama_hotel' => 'sometimes|nullable|string',
            'kota' => 'sometimes|nullable|string',
            'alamat' => 'sometimes|nullable|string',
            'harga' => 'sometimes|nullable|numeric',
            'rating' => 'sometimes|nullable|string',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $hotel = Hotel::findOrFail($id);
        $hotel->nama_hotel = $request->input('nama_hotel', $hotel->nama_hotel);
        $hotel->kota = $request->input('kota', $hotel->kota);
        $hotel->alamat = $request->input('alamat', $hotel->alamat);
        $hotel->harga = $request->input('harga', $hotel->harga);
        $hotel->rating = $request->input('rating', $hotel->rating);

        //jika ada gambar yang diupload
        if ($request->file('gambar')) {
            //menghapus gambar lama jika ada
            if ($hotel->gambar) {
                Storage::delete($hotel->gambar);
            }

            //menyimpan gambar yang baru
            $imgName = time() . '.' . $request->gambar->extension();
            $request->gambar->storeAs('/public/hotels', $imgName);
            $hotel->gambar = '/storage/hotels/' . $imgName;
        }

        if ($hotel->save()) {
            return response()->json("Data hotel berhasil diperbarui", 200);
        } else {
            return response()->json("Terjadi kesalahan saat memperbarui data hotel", 500);
        }
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        //Menghapus gambar dari folder
        if (Storage::delete($hotel->gambar)) {
            //Hapus data hotel dari database
            if ($hotel->delete()) {
                return response()->json([
                    "status" => "1",
                    "message" => "Data hotel telah berhasil dihapus."
                ], 200);
            }
        }
        return response()->json([
            "status" => "0",
            "message" => "Terjadi kesalahan saat menghapus data hotel."
        ], 500);
    }
}
