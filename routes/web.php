<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsLoggedIn;
// controller
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ApprovelController;
use App\Http\Controllers\QrcodeController;
use App\Http\Controllers\PersonalTaskController;
use App\Http\Controllers\HistoryController;

// Tambahkan middleware ke grup rute
Route::middleware(['web', EnsureUserIsLoggedIn::class])->group(function () {

    // Dashboard routes
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/about', [DashboardController::class, 'about'])->name('about');

    // Personal Task Route dengan status sebagai parameter opsional
    Route::get('/personal_task/{status?}', [PersonalTaskController::class, 'personalTask'])->name('personal_task');

    // Route::get('/get-unit-data/{kode}', [PersonalTaskController::class, 'getUnitData']);

    Route::get('/data/view/{kode}', [PersonalTaskController::class, 'viewData'])->name('data.view');



    // Reset Password Route
    Route::get('/reset_password', [DashboardController::class, 'reset_password'])->name('reset_pass');

    // Request routes
    Route::get('/request', [RequestController::class,'index']);
    Route::get('/not_found', [RequestController::class,'not_found']);
    Route::post('/search_nik', [RequestController::class, 'get_data_nik'])->name('search_nik.post');
    Route::post('/insert_request', [RequestController::class, 'insert_request'])->name('insert_request');
    Route::get('/data', [RequestController::class, 'data'])->name('data');

    // History routes
    Route::get('/history', [HistoryController::class, 'index'])->name('history');

    //Reset Password
    Route::get('/reset_password', [HistoryController::class, 'index'])->name('history');
    Route::post('/karyawan/reset-password', [AuthController::class, 'resetPassword'])->name('process-reset-password');

    // Other routes
    Route::get('/search_nik', function () {  return redirect('/not_found'); })->name('search_nik');
    Route::get('/comingsoon', function () {
        $name_page  = "B'Mine - Dashboard";
        return view('comingsoon.comingsoon', compact('name_page'));
    });
    Route::get('/idcard', function () {
        $name_page  = "B'Mine - Dashboard";
        return view('layouts.idcard', compact('name_page'));
    });

    // ID Card PDF generation
    Route::get('karyawan/{id}/idcard-pdf', [PersonalTaskController::class, 'generateIdCard']);

    // View data route
    // Route::get('/view_data/{kode}', [PersonalTaskController::class, 'viewData'])->name('viewData');

    // Approve data routes
    Route::get('/approve_data/{kode}', [PersonalTaskController::class, 'approveData'])->name('approveData');
    Route::get('/approve_data_she/{kode}', [PersonalTaskController::class, 'approveDataSHE'])->name('approveDataSHE');
    Route::get('/approve_data_bec/{kode}', [PersonalTaskController::class, 'approveDataBEC'])->name('approveDataBEC');
    Route::get('/approve_data_ktt/{kode}', [PersonalTaskController::class, 'approveDataKTT'])->name('approveDataKTT');

    // QR Code routes
    Route::get('/qrcode', [QrcodeController::class,'index'])->name('qrcode');
    Route::get('/generatePDF', [QrcodeController::class,'generatePDF'])->name('generatePDF');
    Route::get('/karyawanfolder', [RequestController::class,'karyawanfolder'])->name('karyawanfolder');


});

// Auth routes
Route::get('/login', [AuthController::class,'login'])->name('login');
Route::get('/logout', [AuthController::class,'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
