<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\destinasiModel;
use App\Models\foodModel;
use App\Models\Hotel;
use App\Models\transportModel;
use App\Models\paketModel;
use Illuminate\Support\Facades\DB;

class paketController extends Controller
{


    //membuat paket new
    // public function createPaket(Request $request)
    // {
    //     // Inputan dari agen
    //     $nama_paket = $request->input('nama_paket');
    //     $deskripsi = $request->input('deskripsi');
    //     $hargaPaket = $request->input('harga_paket');
    //     $kota = $request->input('kota');

    //     // Konversi harga ke format numerik
    //     $budgetNumeric = $this->konversiHarga($hargaPaket);

    //     // Ambil data harga dari transport dan hotel
    //     $hotels = Hotel::where('harga', '<=', $budgetNumeric)->get();
    //     $transportasis = TransportModel::where('harga', '<=', $budgetNumeric)->get();

    //     // Ambil data makanan
    //     $food = foodModel::where('kota', $kota)->get();

    //     // Ambil daftar kota unik dari semua tabel
    //     $allCities = collect([]);

    //     $kotaDestinasi = destinasiModel::distinct()->pluck('kota');
    //     $allCities = $allCities->merge($kotaDestinasi);

    //     $kotaFood = foodModel::distinct()->pluck('kota');
    //     $allCities = $allCities->merge($kotaFood);

    //     $kotaHotels = Hotel::distinct()->pluck('kota');
    //     $allCities = $allCities->merge($kotaHotels);

    //     $kotaTransport = transportModel::distinct()->pluck('kota');
    //     $allCities = $allCities->merge($kotaTransport);

    //     $uniqueCities = $allCities->unique();

    //     // Operasi logika atau validasi berdasarkan data yang diperoleh
    //     $paketDibuat = false;

    //     // Logika pembuatan paket
    //     foreach ($hotels as $hotel) {
    //         foreach ($transportasis as $transportasi) {
    //             // Cek apakah kota hotel dan kota transportasi sesuai dengan kota yang diminta
    //             if ($hotel->kota == $kota && $transportasi->kota == $kota) {
    //                 // Hitung total harga paket
    //                 $totalHarga = $hotel->harga + $transportasi->harga;

    //                 // Buat dan simpan paket jika total harga sesuai dengan budget
    //                 if ($totalHarga <= $budgetNumeric) {
    //                     $paket = new paketModel([
    //                         'nama_paket' => $nama_paket,
    //                         'deskripsi' => $deskripsi,
    //                         'harga_paket' => $totalHarga,
    //                         'hotel' => $hotel->nama_hotel,
    //                         'food' => $food->pluck('nama_kuliner')->implode(', '), // Mengambil nama makanan dari koleksi
    //                         'kota' => $kota,
    //                         'id_hotels' => $hotel->id_hotels,
    //                         'id_transportasi' => $transportasi->id_transportasi,
    //                         'id_food' => null, // Anda perlu menyesuaikan ini sesuai kebutuhan
    //                         'id_destinasi' => null, // Anda perlu menyesuaikan ini sesuai kebutuhan
    //                     ]);

    //                     $paket->save();
    //                     $paketDibuat = true;
    //                 }
    //             }
    //         }
    //     }

    //     // Berikan respons sesuai dengan hasil pembuatan paket
    //     if ($paketDibuat) {
    //         return response()->json(['message' => 'Paket berhasil dibuat'], 200);
    //     } else {
    //         return response()->json(['message' => 'Tidak ada paket yang sesuai dengan kota dan budget yang diminta'], 404);
    //     }
    // }



    // Membuat paket
    public function membuatpaket(Request $request)
    {
        $nama_paket = $request->input('nama_paket');
        $deskripsi = $request->input('deskripsi');
        $budget = $request->input('budget');
        $kota =  $request->input('kota');

        // Mengonversi format mata uang ke dalam format numerik
        $budgetNumeric = $this->konversiHarga($budget);

        // Ambil data hotel dan transportasi berdasarkan budget
        $hotels = Hotel::where('harga', '<=', $budgetNumeric)->get();
        $transportasis = TransportModel::where('harga', '<=', $budgetNumeric)->get();

        // Ambil data destinasi sesuai kota dan rating min 4.5
        // $destinasis = destinasiModel::where('kota');
        // $destinasis = DestinasiModel::all();

        //Ambil data food sesuai kota dan rating min 4.5

        //ambil kota dari setiap tabel hotels, transportasi, food, 
        $allkota = 
        DB::table('hotel')
            ->select('kota')
            ->unionAll(DB::table('transportasi'))
            ->unionAll(DB::table('food'))
            ->groupBy('kota')
            ->get();
            
        // foreach ($allkota as $dataKota) {
        //     # code...
        //     $destinasis = DestinasiModel::where([['rating','>=',4.5], ['kota',$dataKota->kota]])->get();
        //     if (count($destinasis) > 0){
        //         $datadestina[] = ["kota" => $dataKota->kota,"destinasis"=>$destinasis];
        //     }             
        // }

        // Membuat paket
        $paketBerhasilDisimpan = false;
        foreach ($hotels as $hotel) {
            foreach ($transportasis as $transportasi) {
                foreach ($destinasis as $destinasi) {
                    // Hitung total harga paket
                    if (!is_numeric($hotel->harga) || !is_numeric($transportasi->harga)) {
                        continue; // Lewati iterasi jika salah satu harga tidak valid
                    }

                    $totalHarga = $hotel->harga + $transportasi->harga;

                    // Buat dan simpan paket jika total harga sesuai dengan budget
                    if ($totalHarga <= $budgetNumeric) {
                        $paket = new paketModel([
                            'nama_paket' => $nama_paket,
                            'deskripsi' => $deskripsi,
                            'transportasi' => $transportasi->nama_transportasi,
                            'jenis_transportasi' => $transportasi->jenis_transportasi,
                            'hotel' => $hotel->nama_hotel,
                            'food' => 'null',
                            'kota' => 'null',
                            'harga_paket' => $totalHarga,
                            'id_hotels' => $hotel->id_hotels,
                            'id_transportasi' => $transportasi->id_transportasi,
                            'id_destinasi' => $destinasi->id_destinasi
                        ]);

                        $paket->save();
                        $paketBerhasilDisimpan = true;
                    }
                }
            }
        }

        if ($paketBerhasilDisimpan) {
            return response()->json(['message' => 'Paket-paket berhasil disimpan'.$paket], 200);
        } else {
            return response()->json(['message' => 'Tidak ada paket yang sesuai dengan budget'], 404);
        }
    }

    // Fungsi untuk mengonversi format mata uang ke dalam format numerik
    private function konversiHarga($harga)
    {
        // Hilangkan karakter non-numeric (seperti "Rp" atau "IDR")
        $numericHarga = preg_replace("/[^0-9]/", "", $harga);

        // Konversi ke format numerik
        $numericHarga = (float) $numericHarga;

        return $numericHarga;
    }

    //read data
    public function index()
    {
        $paket = paketModel::all();
        return response()->json($paket);
    }

    // get per id
    public function showPaket($id)
    {
        $paket = paketModel::find($id);
        if (!$paket) {
            return response()->json(["message" => "Data Paket tidak ditemukan"], 404);
        } else {
            return response()->json($paket);
        }
    }
}
