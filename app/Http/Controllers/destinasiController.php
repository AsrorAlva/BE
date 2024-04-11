<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\destinasiModel;

class destinasiController extends Controller
{
    //read data
    public function index()
    {
        $destinasi = destinasiModel::all();
        return response()->json($destinasi);
    }

}
