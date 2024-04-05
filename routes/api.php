<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\AgenController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\hotelsController;
use App\Http\Controllers\TransportasiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {

    //pengguna
    Route::post('/user/register', [PenggunaController::class, 'register']);
    Route::post('/user/login', [PenggunaController::class, 'login']);
    Route::get('/user/profile/{id}', [PenggunaController::class, 'show']);
    Route::get('/user/profile/', [PenggunaController::class, 'index']);
    Route::put('/update/{id}', [PenggunaController::class, 'update']); // Update
    Route::delete('/user/{id}', [PenggunaController::class, 'destroy']); // Delete


    //agen
    // Route::post('login', [LoginController::class, 'login']);
    // Route::post('register', [RegisterController::class, 'register']);  
    Route::get('agen', [AgenController::class, 'index']);
    Route::get('agen/{id}', [AgenController::class, 'show']); // Read Single
    Route::post('agen/store', [AgenController::class, 'store']); // Create
    Route::put('agen/{id}', [AgenController::class, 'update']); // Update
    Route::delete('agen/{id}', [AgenController::class, 'destroy']); // Delete
    Route::post('agen/login', [AgenController::class, 'login']);


    //Admin
    Route::post('admin/login', [AdminController::class, 'login']);
    Route::post('admin/logout', [AdminController::class, 'logout']);


    //Paket


    //Hotel

    Route::get('/hotels', [hotelsController::class, 'index']); //Read All



    //transport
    Route::get('/transportasi', [TransportasiController::class, 'index']); //Read All
    Route::get('/transportasi/{jenis}', [TransportasiController::class, 'berdasarkanJenis']); //jenis
    Route::get('/transportasi/harga/{harga}', [TransportasiController::class, 'harga']); //harga


});
