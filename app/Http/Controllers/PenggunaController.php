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
            'password' => bcrypt($request->password),
            'no_tlpn' => $request->no_tlpn,
        ]);

        return response()->json(['message' => 'Registrasi berhasil', 'pengguna' => $pengguna]);
    }

    // Login Pengguna
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('Personal Access Token')->accessToken;
            return response()->json(['message' => 'Login berhasil', 'user' => $user, 'access_token' => $token]);
        } else {
            return response()->json(['message' => 'Login gagal'], 401);
        }
    }

    // Update Profil Pengguna
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:pengguna,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:pengguna,email,' . $user->id,
            'no_tlpn' => 'required|string|max:15',
        ]);

        $user->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'no_tlpn' => $request->no_tlpn,
        ]);

        return response()->json(['message' => 'Profil berhasil diperbarui', 'user' => $user]);
    }
}
