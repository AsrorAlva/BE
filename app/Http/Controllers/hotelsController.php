<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Hotel;


class hotelsController extends Controller
{
    //read data for paket
    public function index()
    {
        $hotel = Hotel::all();
        return response()->json($hotel);
    }
    

    //read kota


}
