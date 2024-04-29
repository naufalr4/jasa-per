<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\JasaController;

use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\sliderController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UlasanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'session',
    'prefix' => 'auth'
], function () {
    Route::post('admin', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::post('logout', [AuthController::class, 'logout']);
});



Route::group([
    'middleware' => 'api',
], function () {
    Route::resources([
        'categories' => CategoryController::class,
        'subcategories' => SubcategoryController::class,
        'sliders' => sliderController::class,
        'jasas' => JasaController::class,
        'konsumens' => KonsumenController::class,
        'ulasans' => UlasanController::class,
        'orders' => OrderController::class,
        'pembayarans' => PembayaranController::class,
    ]);

    Route::get('perbaikan/baru', [OrderController::class, 'baru']);
    Route::get('perbaikan/dikonfirmasi', [OrderController::class, 'dikonfirmasi']);
    Route::get('perbaikan/diproses', [OrderController::class, 'diproses']);
    Route::get('perbaikan/diperbaiki', [OrderController::class, 'diperbaiki']);
    Route::get('perbaikan/diterima', [OrderController::class, 'diterima']);
    Route::get('perbaikan/selesai', [OrderController::class, 'selesai']);
    Route::post('perbaikan/ubah_status/{order}', [OrderController::class, 'ubah_status']);

    Route::get('laporans', [LaporanController::class, 'index']);
});
