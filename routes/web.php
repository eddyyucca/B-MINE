<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\QrcodeController;

// dashboard
Route::get('/', [AuthController::class, 'login'])->name('login');

Route::get('/dashboard', [DashboardController::class, 'dashboard_external'])->name('dashboard_external');

// Route::get('/dashboard_external', [DashboardController::class, 'dashboard_external'])->name('dashboard_external');

Route::get('/about', [DashboardController::class, 'about'])->name('about');

// Auth
Route::get('/login', [AuthController::class,'login'])->name('login');
Route::post('/auth', [AuthController::class,'auth'])->name('auth');
Route::get('/auth', function () {
    return redirect()->route('login')->with('error', 'Harap login terlebih dahulu.');
});

// request
Route::get('/request', [RequestController::class,'index']);
Route::get('/not_found', [RequestController::class,'not_found']);

Route::get('/search_nik', function () {  return redirect('/not_found'); })->name('search_nik');
Route::post('/search_nik', [RequestController::class, 'get_data_nik'])->name('search_nik.post');

// comingsoon
Route::get('/comingsoon', function () {
    return view('comingsoon.comingsoon');
});

// cobaqrcode
    Route::get('/qrcode', [QrcodeController::class,'index'])->name('qrcode');
    Route::get('/generatePDF', [QrcodeController::class,'generatePDF'])->name('generatePDF');