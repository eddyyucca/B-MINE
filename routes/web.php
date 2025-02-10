<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureUserIsLoggedIn;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ApprovelController;
use App\Http\Controllers\QrcodeController;
use App\Http\Controllers\PersonalTaskController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\OutstandingController;

Route::middleware(['web', EnsureUserIsLoggedIn::class])->group(function () {
   // Dashboard
   Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
   Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
   Route::get('/about', [DashboardController::class, 'about'])->name('about');

   // Personal Tasks
   Route::get('/personal_task/{status?}', [PersonalTaskController::class, 'personalTask'])->name('personal_task');
   Route::get('/personal_task_admin', [PersonalTaskController::class, 'adminTask'])->name('admin.task');
   Route::get('/personal_task_she', [PersonalTaskController::class, 'sheTask'])->name('she.task');
   Route::get('/personal_task_pjo', [PersonalTaskController::class, 'pjoTask'])->name('pjo.task');
   Route::get('/personal_task_bec', [PersonalTaskController::class, 'becTask'])->name('bec.task');
   Route::get('/personal_task_ktt', [PersonalTaskController::class, 'kttTask'])->name('ktt.task');
   Route::get('/personal_task_rejected', [PersonalTaskController::class, 'rejectTask'])->name('reject.task');
   Route::post('/reject-request/{stage}/{kode}', [PersonalTaskController::class, 'rejectRequest'])->name('reject.request');
   Route::get('/view-data/{kode}', [PersonalTaskController::class, 'viewData'])->name('view.data');
   Route::get('/data/view/{kode}', [PersonalTaskController::class, 'viewData'])->name('data.view');

   // Reset Password
   Route::get('/reset_password', [DashboardController::class, 'reset_password'])->name('reset_pass');

   // Request Routes
   Route::get('/request', [RequestController::class,'index']);
   Route::get('/not_found', [RequestController::class,'not_found']);
   Route::post('/search_nik', [RequestController::class, 'get_data_nik'])->name('search_nik.post');
   Route::post('/insert_request', [RequestController::class, 'insert_request'])->name('insert_request');
   Route::get('/data', [RequestController::class, 'data'])->name('data');

    // History routes
    Route::get('/history', [HistoryController::class, 'index'])->name('history');
    // Outstanding routes
    Route::get('/outstanding', [OutstandingController::class, 'index'])->name('outstanding');

   // Static Pages
   Route::get('/search_nik', function () {
       return redirect('/not_found');
   })->name('search_nik');

   Route::get('/comingsoon', function () {
       $name_page = "B'Mine - Dashboard";
       return view('comingsoon.comingsoon', compact('name_page'));
   });

   Route::get('/idcard', function () {
       $name_page = "B'Mine - Dashboard";
       return view('layouts.idcard', compact('name_page'));
   });

   // ID Card Generation
   Route::get('karyawan/{id}/idcard-pdf', [PersonalTaskController::class, 'generateIdCard']);

   // Approval Routes
   Route::get('/approve_data/{kode}', [PersonalTaskController::class, 'approveData'])->name('approveData');
   Route::get('/approve_data_she/{kode}', [PersonalTaskController::class, 'approveDataShe'])->name('approveDataShe');
   Route::get('/approve_data_pjo/{kode}', [PersonalTaskController::class, 'approveDataPjo'])->name('approveDataPjo');
   Route::get('/approve_data_bec/{kode}', [PersonalTaskController::class, 'approveDataBec'])->name('approveDataBec');
   Route::get('/approve_data_ktt/{kode}', [PersonalTaskController::class, 'approveDataKtt'])->name('approveDataKtt');

   Route::post('/reject-request/{kode}', [PersonalTaskController::class, 'rejectRequest'])->name('reject.request');
   Route::put('/clear-reject-history/{kode}', [PersonalTaskController::class, 'clearRejectHistory'])->name('clear.reject.history');

    // PRINT ID CARD
   Route::get('/generate-idcardFront/{kode}', [PersonalTaskController::class, 'generateIdCardFront']);
   Route::get('/generate-idcardBack/{kode}', [PersonalTaskController::class, 'generateIdCardBack']);


   // QR Code
   Route::get('/qrcode', [QrcodeController::class,'index'])->name('qrcode');
   Route::get('/generatePDF', [QrcodeController::class,'generatePDF'])->name('generatePDF');
   Route::get('/karyawanfolder', [RequestController::class,'karyawanfolder'])->name('karyawanfolder');
});

// Public route untuk QR code scan
Route::get('/verifikasi/{kode}', [PersonalTaskController::class, 'scanQR'])->name('scan.qr');

// Authentication
Route::get('/login', [AuthController::class,'login'])->name('login');
Route::get('/logout', [AuthController::class,'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
