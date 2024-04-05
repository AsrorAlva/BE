<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agen;

class AgenController extends Controller
{
    public function index()
    {
        $agenList = Agen::all();
        return response()->json($agenList);
    }

    public function show($id)
    {
        $agen = Agen::findOrFail($id);
        return response()->json($agen);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:agen',
            'password' => 'required',
        ]);

        $agen = new Agen();
        $agen->name = $request->name;
        $agen->username = $request->username;
        $agen->password = $request->password;
        $agen->save();

        return response()->json(['message' => 'Agen created successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:agen,username,'.$id.',id_agen', // Perhatikan perubahan ini
            'password' => 'required',
        ]);
    
        $agen = Agen::findOrFail($id);
        $agen->name = $request->name;
        $agen->username = $request->username;
        $agen->password = $request->password;
        $agen->save();
    
        return response()->json(['message' => 'Agen updated successfully']);
    }
    

    public function destroy($id)
    {
        $agen = Agen::findOrFail($id);
        $agen->delete();

        return response()->json(['message' => 'Agen deleted successfully']);
    }


    // public function login(Request $request)
    // {
    //     $credentials = $request->only('username', 'password');

    //     if (Agen::guard('agen')->attempt($credentials)) {
    //         $user = Agen::guard('agen')->user();
    //         return response()->json(['message' => 'Login successful', 'user' => $user]);
    //     }

    //     return response()->json(['message' => 'Login failed'], 401);
    // }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $emailExist = Agen::where("username", $request->username)->first();

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

    public function logout()
    {
        Auth::guard('agen')->logout();
        return response()->json(['message' => 'Logout berhasil'], 200);
    }
}
