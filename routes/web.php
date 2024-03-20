<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\JasaPerbaikanController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\sliderController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\UlasanController;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Route;

//auth
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout']);

Route::get('login_konsumen', [AuthController::class, 'login_konsumen']);
Route::post('login_konsumen', [AuthController::class, 'login_konsumen_action']);
Route::get('logout_konsumen', [AuthController::class, 'logout_konsumen']);

Route::get('register_konsumen', [AuthController::class, 'register_konsumen']);
Route::post('register_konsumen', [AuthController::class, 'register_konsumen_action']);

//kategori
Route::get('/kategori', [CategoryController::class, 'list']);
Route::get('/subkategori', [SubcategoryController::class, 'list']);
Route::get('/slider', [sliderController::class, 'list']);
Route::get('/jasa', [JasaController::class, 'list']);
Route::get('/ulasan', [UlasanController::class, 'list']);
Route::get('/pembayaran', [PembayaranController::class, 'list']);

Route::get('/perbaikan/baru', [orderController::class, 'list']);
Route::get('/perbaikan/dikonfirmasi', [orderController::class, 'dikonfirmasi_list']);
Route::get('/perbaikan/diproses', [orderController::class, 'diproses_list']);
Route::get('/perbaikan/diperbaiki', [orderController::class, 'diperbaiki_list']);
Route::get('/perbaikan/diterima', [orderController::class, 'diterima_list']);
Route::get('/perbaikan/selesai', [orderController::class, 'selesai_list']);

Route::get('/tentang', [TentangController::class, 'index']);
Route::post('/tentang/{about}', [TentangController::class, 'update']);

Route::get('/dashboard', [DashboardController::class, 'index']);

// home routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/jasas/{category}', [HomeController::class, 'jasas']);
Route::get('/jasa/{id}', [HomeController::class, 'jasa']);
Route::get('/cart', [HomeController::class, 'cart']);
Route::get('/checkout', [HomeController::class, 'checkout']);
Route::get('/orders', [HomeController::class, 'orders']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/faq', [HomeController::class, 'faq']);

Route::post('/add_to_cart', [HomeController::class, 'add_to_cart']);
Route::get('/delete_from_cart/{cart}', [HomeController::class, 'delete_from_cart']);
Route::get('/get_kota/{id}', [HomeController::class, 'get_kota']);
Route::get('/get_ongkir/{destination}/{weight}', [HomeController::class, 'get_ongkir']);
Route::post('/checkout_orders', [HomeController::class, 'checkout_orders']);
Route::post('/payments', [HomeController::class, 'payments']);
Route::post('/pesanan_selesai/{order}', [HomeController::class, 'pesanan_selesai']);
