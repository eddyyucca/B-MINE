<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ApprovelController;
use App\Http\Controllers\QrcodeController;
use App\Http\Controllers\PersonalTaskController;

// dashboard
Route::get('/', [AuthController::class, 'login'])->name('login');

// Route::get('/dashboard', [DashboardController::class, 'dashboard_external'])->name('dashboard_external');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/about', [DashboardController::class, 'about'])->name('about');
Route::get('/personal_task', [ApprovalController::class, 'personal_task'])->name('personal_task');

// Auth
Route::get('/login', [AuthController::class,'login'])->name('login');
Route::get('/logout', [AuthController::class,'logout'])->name('logout');
Route::post('/auth', [AuthController::class,'auth'])->name('auth');
Route::get('/auth', function () {
    return redirect()->route('login')->with('error', 'Harap login terlebih dahulu.');
});

// request
Route::get('/request', [RequestController::class,'index']);
Route::get('/not_found', [RequestController::class,'not_found']);

Route::get('/search_nik', function () {  return redirect('/not_found'); })->name('search_nik');
Route::post('/search_nik', [RequestController::class, 'get_data_nik'])->name('search_nik.post');
Route::post('/insert_request', [RequestController::class, 'insert_request'])->name('insert_request');

Route::get('/data', [RequestController::class, 'data'])->name('data');
// comingsoon
Route::get('/comingsoon', function () {
    return view('comingsoon.comingsoon');
});

// personal task
Route::get('/personal_tak', [PersonalTaskController::class, 'index'])->name('personal_tak');
Route::get('/view_data/{kode}', [PersonalTaskController::class, 'viewData'])->name('viewData');
Route::get('/approve_data/{kode}', [PersonalTaskController::class, 'approveData'])->name('approveData');

// cobaqrcode
    Route::get('/qrcode', [QrcodeController::class,'index'])->name('qrcode');
    Route::get('/generatePDF', [QrcodeController::class,'generatePDF'])->name('generatePDF');
    Route::get('/karyawanfolder', [RequestController::class,'karyawanfolder'])->name('karyawanfolder');