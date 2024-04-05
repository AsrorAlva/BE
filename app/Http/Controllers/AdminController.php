<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminController extends Controller
{
    // Proses login admin
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $emailExist = Admin::where("username", $request->username)->first();

        // Proses autentikasi
        if ($emailExist) {
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

    // Logout admin
    public function logout()
    {
        Auth::guard('admin')->logout();
        return response()->json(['message' => 'Logout berhasil'], 200);
    }
}
