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


    //show detail hotel by id
    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);
        return response()->json($hotel);
    }

    //create
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_hotel' => 'required|string',
            'kota' =>  'required|string',
            'alamat' => 'required|string',
            'harga' => 'required|string',
            'rating' => 'required|string',
            'gambar' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048'
        ]);

        if ($validator->fails())
            return response()->json([$validator->errors()]);

        // $imageName = null;
        // if ($request->file('gambar')) {
        //     $imageName = time().'.'.$request->gambar->extension();    
        //     $request->gambar->move(public_path('img'), $imageName);    
        // }       

        $data = new Hotel;
        $data->nama_hotel = $request->nama_hotel;
        $data->kota = $request->kota;
        $data->alamat = $request->alamat;
        $data->harga = $request->harga;
        $data->rating = $request->rating;
        // $data -> gambar = $imageName;    
        $data->save();

        return response()->json(['message' => 'Data Berhasil Disimpan' . $data], 201);
    }


    //edit data
    public function update(Request $request, $id)
{
    $hotel = Hotel::find($id);

    if (!$hotel) {
        return response()->json(['message' => 'Data hotel tidak ditemukan'], 404);
    }

    $validator = Validator::make($request->all(), [
        'nama_hotel' => 'sometimes',
        'kota' => 'sometimes',
        'alamat' => 'sometimes',
        'harga' => 'sometimes',
        'rating' => 'sometimes',
        'gambar' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Parameter tidak valid',
            'errors' => $validator->errors()
        ], 422);
    }

    // Update data hotel berdasarkan input yang diberikan
    $hotel->nama_hotel = $request->nama_hotel ?? $hotel->nama_hotel;
    $hotel->kota = $request->kota ?? $hotel->kota;
    $hotel->alamat = $request->alamat ?? $hotel->alamat;
    $hotel->harga = $request->harga ?? $hotel->harga;
    $hotel->rating = $request->rating ?? $hotel->rating;

    // Jika ada gambar baru diunggah, proses gambar tersebut
    if ($request->hasFile('gambar')) {
        $gambar = $request->file('gambar');
        $filename = time() . '.' . $gambar->getClientOriginalExtension();
        $path = 'uploads/';
        $gambar->move($path, $filename);
        $hotel->gambar = $path . $filename;
    }

    // Simpan perubahan data hotel
    $hotel->save();

    return response()->json(['message' => 'Data hotel berhasil diperbarui', 'data' => $hotel], 200);
}

    // // $rules=[
    // //     'nama_hotel' => 'sometimes|required|string',
    // //     'kota' =>  'sometimes|required|string',
    // //     'alamat'=> 'sometimes|required|string',
    // //     'harga' => 'sometimes|required|numeric',
    // //     'rating' => 'sometimes|required|integer',
    // //     'gambar' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048'      
    // //     ];

    // // $costumMessages = [
    // //     'required' => 'Field :attribute wajib diisi.',
    // //     'string' => 'Field :attribute harus berupa string.',
    // //     'numeric' => 'Field :attribute harus berupa angka.',
    // //     'integer' => 'Field :attribute harus berupa integer.' ,
    // //     'gambar.mimes' => 'Gambar wajib bertipe jpg/png/webp.',
    // //     'gambar.max' => 'Ukuran maksimum gambar adalah 2MB.'

    // // ];

    // $validator=Validator::make($request->all(),$rules,$costumMessages)->validate();

    // // if ($request->gambar) {
    // //     $imageName = time().'.'.$request->gambar->extension();    
    // //     $request->gambar->move(public_path('img'), $imageName);
    // //     $Hotel->gambar = $imageName;
    // // }

    // $Hotel->update([
    //     'nama_hotel' => $request->nama_hotel,
    //     'kota' => $request->kota,
    //     'alamat' => $request->alamat,
    //     'harga' => $request->harga,
    //     'rating' => $request->rating
    // ]);

    // return redirect('/admin/data-hotel')->with('status','Data hotel telah diubah!');


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





    // public function create(Request $request)
    // {
    //     // Validasi
    //     $validator = Validator::make($request->all(), [
    //         'nama_paket' => 'required|string',
    //         'deskripsi' => 'required|string',
    //         'destinasi' => 'required|string',
    //         'transportasi' => 'required|string',
    //         'akomodasi' => 'required|string',
    //         'harga_paket' => 'required|string',
    //         'fasilitas' => 'required|string',
    //         'kuliner' => 'required|string',
    //         'image' => 'nullable|array',
    //         'image.*' => 'nullable|mimes:png,jpg,jpeg,webp|max:2048',
    //         'rating' => 'required|string',
    //     ]);

    //     // Jika validasi gagal, kembalikan respons dengan pesan kesalahan
    //     if ($validator->fails()) {
    //         return response()->json(['message' => 'Validasi gagal', 'errors' => $validator->errors()], 422);
    //     }

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
    //         $files = $request->file('image');
    //         $filenames = [];
    //         $path = 'uploads/';

    //         foreach ($files as $file) {
    //             $filename = time() . '.' . $file->getClientOriginalExtension();
    //             $file->move($path, $filename);
    //             $filenames[] = $filename;
    //         }

    //         $data['image'] = json_encode($filenames);
    //     }


    //     // Simpan data ke dalam database
    //     $paket = Hotel::create($data);

    //     // Jika berhasil disimpan, kirim respons berhasil
    //     if ($paket) {
    //         return response()->json(['message' => 'Paket berhasil dibuat', 'data' => $paket], 201);
    //     }

    //     // Jika gagal menyimpan, kirim respons gagal
    //     return response()->json(['message' => 'Gagal membuat paket'], 500);
    // }
}
