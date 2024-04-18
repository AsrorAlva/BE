<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\destinasiModel;
use App\Models\Hotel;
use App\Models\transportModel;
use App\Models\paketModel;

class paketController extends Controller
{
    // Membuat paket
    public function membuatpaket(Request $request)
    {
        $budget = $request->input('budget');

        // Mengonversi format mata uang ke dalam format numerik
        $budgetNumeric = $this->konversiHarga($budget);

        // Ambil data hotel dan transportasi berdasarkan budget
        $hotels = Hotel::where('harga', '<=', $budgetNumeric)->get();
        $transportasis = TransportModel::where('harga', '<=', $budgetNumeric)->get();

        // Ambil semua data destinasi
        $destinasis = DestinasiModel::all();

        // Membuat paket
        $paketBerhasilDisimpan = false;
        foreach ($hotels as $hotel) {
            foreach ($transportasis as $transportasi) {
                foreach ($destinasis as $destinasi) {
                    // Hitung total harga paket
                    $totalHarga = $hotel->harga + $transportasi->harga;

                    // Buat dan simpan paket jika total harga sesuai dengan budget
                    if ($totalHarga <= $budgetNumeric) {
                        $paket = new paketModel([
                            'nama_paket' => 'Paket ' . $hotel->nama_hotel . ' - ' . $transportasi->nama_transportasi . ' - ' . $destinasi->nama_destinasi,
                            'deskripsi' => 'Deskripsi paket...',
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
            return response()->json(['message' => 'Paket-paket berhasil disimpan'], 200);
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

    public function show($id)
    {
        $paket = paketModel::findOrFail($id);
        return response()->json($paket);
    }
}
