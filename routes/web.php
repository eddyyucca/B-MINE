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
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/about', [DashboardController::class, 'about'])->name('about');
    Route::get('/personal_task', [PersonalTaskController::class, 'index'])->name('personal_task');

// Auth
Route::get('/login', [AuthController::class,'login'])->name('login');
Route::get('/logout', [AuthController::class,'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/auth', [AuthController::class,'auth'])->name('auth');
Route::get('/auth', function () {
    return redirect()->route('login')->with('error', 'Harap login terlebih dahulu.');
});
// setting
Route::get('/reset_password', [DashboardController::class, 'reset_password'])->name('reset_pass');

// request
Route::get('/request', [RequestController::class,'index']);
Route::get('/not_found', [RequestController::class,'not_found']);
// history
Route::get('/history', [HistoryController::class, 'index'])->name('history');

Route::get('/search_nik', function () {  return redirect('/not_found'); })->name('search_nik');
Route::post('/search_nik', [RequestController::class, 'get_data_nik'])->name('search_nik.post');
Route::post('/insert_request', [RequestController::class, 'insert_request'])->name('insert_request');
Route::get('/data', [RequestController::class, 'data'])->name('data');
// comingsoon
Route::get('/comingsoon', function () {
     $name_page  = "B'Mine - Dashboard";
    return view('comingsoon.comingsoon', compact('name_page'));
});

// personal task
// Route::get('/personal_task', [PersonalTaskController::class, 'index'])->name('personal_tak');
Route::get('/personal_task_she', [PersonalTaskController::class, 'personal_task_she'])->name('personal_task_she');
Route::get('/personal_task_pjo', [PersonalTaskController::class, 'personal_task_pjo'])->name('personal_task_pjo');
Route::get('/personal_task_bec', [PersonalTaskController::class, 'personal_task_bec'])->name('personal_task_bec');
Route::get('/personal_task_ktt', [PersonalTaskController::class, 'personal_task_ktt'])->name('personal_task_ktt');
Route::get('/view_data/{kode}', [PersonalTaskController::class, 'viewData'])->name('viewData');

Route::get('/approve_data/{kode}', [PersonalTaskController::class, 'approveData'])->name('approveData');
Route::get('/approve_data_she/{kode}', [PersonalTaskController::class, 'approveDataSHE'])->name('approveDataSHE');
Route::get('/approve_data_bec/{kode}', [PersonalTaskController::class, 'approveDataBEC'])->name('approveDataBEC');
Route::get('/approve_data_ktt/{kode}', [PersonalTaskController::class, 'approveDataKTT'])->name('approveDataKTT');
// cobaqrcode
    Route::get('/qrcode', [QrcodeController::class,'index'])->name('qrcode');
    Route::get('/generatePDF', [QrcodeController::class,'generatePDF'])->name('generatePDF');
    Route::get('/karyawanfolder', [RequestController::class,'karyawanfolder'])->name('karyawanfolder');

    });