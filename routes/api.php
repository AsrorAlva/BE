<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\AgenController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\hotelsController;
use App\Http\Controllers\TransportasiController;
use App\Http\Controllers\destinasiController;
use App\Http\Controllers\paketController;
use App\Http\Controllers\paket2Controller;

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
    Route::post('/hotel/create', [hotelsController::class, 'createHotel']); //CreateHotel



    //transport
    Route::get('/transportasi', [TransportasiController::class, 'index']); //Read All
    Route::post('/transport/create', [TransportasiController::class, 'createTransport']); //CreateHotel
    Route::put('updateTransport/{id}', [TransportasiController::class, 'updateTransport']); // Update
    Route::get('transport/{id}', [TransportasiController::class, 'show']); // Read Single
    Route::delete('transport/{id}', [TransportasiController::class, 'deleteTransport']); // Read Single

    //destinasi
    Route::get('/destinasi', [destinasiController::class, 'index']); //Read All



    //paket

    //buatpaket
    Route::post('/paket/generate', [paketController::class, 'membuatpaket']);



    //paket2
    Route::post('/paket/buat', [paket2Controller::class, 'create']); //create
    Route::get('/paket', [paket2Controller::class, 'read']); //Read All
    Route::put('updatepaket/{id}', [paket2Controller::class, 'update']); // Update
    // Route::put('updatepaket/{id}', [paket2Controller::class, 'edit']); // Update
    Route::get('paket/{id}', [paket2Controller::class, 'show']); // Read Single

    Route::get('caripaket', [paket2Controller::class, 'paketForUser']); // Read Single
    






});
