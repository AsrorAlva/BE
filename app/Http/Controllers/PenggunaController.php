<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;

class PenggunaController extends Controller
{
    // Registrasi Pengguna
    public function register(Request $request)
{
    try {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:pengguna',
            'email' => 'required|string|email|max:255|unique:pengguna',
            'password' => 'required|string|min:8',
            'no_tlpn' => 'required|string|max:15',
        ]);

        $pengguna = Pengguna::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'password' => ($request->password),
            'no_tlpn' => $request->no_tlpn,
        ]);

        return response()->json(['message' => 'Registrasi berhasil', 'pengguna' => $pengguna], 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Registrasi gagal', 'error' => $e->getMessage()], 500);
    }
}

    // Login Pengguna

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    
        // Cari pengguna berdasarkan email
        $emailExist = Pengguna::where("email", $request->email)->first();
    
        // Proses autentikasi
        if ($emailExist) {
            // Jika pengguna ditemukan, verifikasi password
            if ($emailExist->password  == $request->password) {
                // Jika autentikasi berhasil, kirim respons berhasil
                return response()->json(['message' => 'Login berhasil'], 200);
            } else {
                return response()->json(['message' => 'Password salah!!!'], 401);
            }
        } else {
            // Jika autentikasi gagal, kirim respons gagal
            return response()->json(['message' => 'Email belum terdaftar!!!'], 401);
        }
    }
    

    //update pengguna
    public function update(Request $request, $id)
    {
        try {
            // Temukan pengguna berdasarkan ID
            $pengguna = Pengguna::findOrFail($id);
        
            // Perbarui atribut pengguna dengan nilai yang diterima dari permintaan
            $pengguna->nama = $request->nama;
            $pengguna->username = $request->username;
            $pengguna->password = $request->password;
            $pengguna->no_tlpn = $request->no_tlpn;
    
            // Simpan perubahan
            $pengguna->save();
    
            // Kirim respons JSON untuk memberi tahu bahwa pengguna telah berhasil diperbarui
            return response()->json(['message' => 'Pengguna updated successfully', 'pengguna' => $pengguna], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Tangkap dan tanggapi kesalahan jika pengguna tidak ditemukan
            return response()->json(['message' => 'Failed to update pengguna: Pengguna not found'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangkap dan tanggapi kesalahan jika validasi gagal
            return response()->json(['message' => 'Failed to update pengguna: Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Tangkap dan tanggapi kesalahan umum jika terjadi kesalahan lain
            return response()->json(['message' => 'Failed to update pengguna', 'error' => $e->getMessage()], 500);
        }
    }
    


    //read data

    public function index()
    {
        // Ambil semua pengguna dari tabel
        $penggunaList = Pengguna::all();

        // Kembalikan daftar pengguna dalam format JSON
        return response()->json($penggunaList);
    }

    //read data per $id
    public function show($id)
    {
        // Cari pengguna berdasarkan ID
        $pengguna = Pengguna::findOrFail($id);

        // Kembalikan data pengguna dalam format JSON
        return response()->json($pengguna);
    }

    public function destroy($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->delete();

        return response()->json(['message' => 'Pengguna deleted successfully']);
    }
}
