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
use App\Http\Controllers\AkunController;
use App\Http\Controllers\CompletedController;
use App\Http\Controllers\ChunkedUploadController; // Tambahkan import untuk controller baru

// Authentication Routes (Public)
Route::middleware(['web'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Public route for QR code scanning
    Route::get('/verifikasi/{nik}', [PersonalTaskController::class, 'scanQR'])->name('scan.qr');
});

// Protected Routes
Route::middleware(['web', EnsureUserIsLoggedIn::class])->group(function () {
    // Dashboard
    Route::get('/{path?}', [DashboardController::class, 'index'])
    ->where('path', 'dashboard|')
    ->name('dashboard');
    Route::get('/about', [DashboardController::class, 'about'])->name('about');
    Route::get('/reset_password', [DashboardController::class, 'reset_password'])->name('reset_pass');
    
    // Route untuk chunked upload (tambahkan di sini)
    Route::post('/upload/chunk', [ChunkedUploadController::class, 'uploadChunk'])->name('upload.chunk');
    
    // Charts API
    Route::prefix('api')->group(function () {
        Route::get('/permit-requests', [DashboardController::class, 'getPermitRequestsData']);
        Route::post('/permit-requests/custom', [DashboardController::class, 'getCustomRangeData']);
    });
    
    // Request Routes
    Route::prefix('request')->group(function () {
        Route::get('/', [RequestController::class, 'index'])->name('request.index');
        Route::get('/not_found', [RequestController::class, 'not_found'])->name('request.not_found');
        Route::match(['Post'], '/search_nik', [RequestController::class, 'get_data_nik'])
        ->name('search_nik.post');
        Route::post('/insert', [RequestController::class, 'insert_request'])->name('insert_request');
        Route::get('/data', [RequestController::class, 'data'])->name('data');
        Route::get('/karyawanfolder', [RequestController::class, 'karyawanfolder'])->name('karyawanfolder');
    });
    
    // Personal Tasks Routes
Route::prefix('personal_task')->group(function () {
    Route::get('/{status?}', [PersonalTaskController::class, 'personalTask'])->name('personal_task');
    Route::get('/admin/view', [PersonalTaskController::class, 'adminTask'])->name('admin.task');
    Route::get('/she/view', [PersonalTaskController::class, 'sheTask'])->name('she.task');
    Route::get('/pjo/view', [PersonalTaskController::class, 'pjoTask'])->name('pjo.task');
    Route::get('/bec/view', [PersonalTaskController::class, 'becTask'])->name('bec.task');
    Route::get('/ktt/view', [PersonalTaskController::class, 'kttTask'])->name('ktt.task');
    Route::get('/rejected/view', [PersonalTaskController::class, 'rejectTask'])->name('reject.task');
    Route::get('/pjo/approve-all', [PersonalTaskController::class, 'approveAllPjo'])->name('approve.all.pjo');
     Route::get('/ktt/approve-all', [PersonalTaskController::class, 'approveAllKtt'])->name('approve.all.ktt');
});
    
    // Approval Routes
    Route::prefix('approve')->group(function () {
        Route::get('/data/{kode}', [PersonalTaskController::class, 'approveData'])->name('approveData');
        Route::get('/data_she/{kode}', [PersonalTaskController::class, 'approveDataShe'])->name('approveDataShe');
        Route::get('/data_pjo/{kode}', [PersonalTaskController::class, 'approveDataPjo'])->name('approveDataPjo');
        Route::get('/data_bec/{kode}', [PersonalTaskController::class, 'approveDataBec'])->name('approveDataBec');
        Route::get('/data_ktt/{kode}', [PersonalTaskController::class, 'approveDataKtt'])->name('approveDataKtt');
    });
    
    // Reject Request - dengan parameter opsional untuk fleksibilitas
    Route::post('/reject-request/{stage?}/{kode?}', [PersonalTaskController::class, 'rejectRequest'])->name('reject.request');
    Route::put('/clear-reject-history/{kode}', [PersonalTaskController::class, 'clearRejectHistory'])->name('clear.reject.history');
    
    // View Data Routes
    Route::get('/view-data/{kode}', [PersonalTaskController::class, 'viewData'])->name('view.data');
    Route::get('/data/view/{kode}', [PersonalTaskController::class, 'viewData'])->name('data.view');
    
  // Account Routes     
Route::prefix('akun')->group(function () {
    // View routes
    Route::get('/external', [AkunController::class, 'akun_external'])->name('dataaccounts_ext.view');
    Route::get('/internal', [AkunController::class, 'akun_internal'])->name('dataaccounts_int.view');
    
    // Add form routes
    Route::get('/external/tambah', [AkunController::class, 'tambah_external'])->name('dataaccounts_ext.tambah');
    Route::get('/internal/tambah', [AkunController::class, 'tambah_internal'])->name('dataaccounts_int.tambah');
    
    // Post routes untuk menyimpan data
    Route::post('/external/store', [AkunController::class, 'store_external'])->name('dataaccounts_ext.store');
    Route::post('/internal/store', [AkunController::class, 'store_internal'])->name('dataaccounts_int.store');
    
    // Route baru untuk update level
    Route::post('/internal/update-level', [AkunController::class, 'update_level'])->name('dataaccounts_int.update_level');
    
  // Routes baru untuk delete accounts
    Route::delete('/internal/delete', [AkunController::class, 'delete_internal'])->name('dataaccounts_int.delete');
    Route::delete('/external/delete', [AkunController::class, 'delete_external'])->name('dataaccounts_ext.delete');   

     // Password change routes
    Route::get('/change-password', [AkunController::class, 'changePassword'])->name('akun.change_password');
    Route::post('/update-password', [AkunController::class, 'updatePassword'])->name('akun.update_password');
});
    
    // Completed Routes
    Route::prefix('completed')->group(function () {
        Route::get('/submission', [CompletedController::class, 'data_completed'])->name('data_completed');
        Route::get('/accept/{kode}', [CompletedController::class, 'accept'])->name('accept');
    });
    
    // ID Card Generation
    Route::prefix('idcard')->group(function () {
        Route::get('/', function () {
            $name_page = "B'Mine - Card";
            return view('layouts.idcard', compact('name_page'));
        });
        Route::get('/karyawan/{id}/pdf', [PersonalTaskController::class, 'generateIdCard']);
        Route::get('/generate-idcardFront/{nik}', [PersonalTaskController::class, 'generateIdCardFront']);
        Route::get('/generate-idcardBack/{nik}', [PersonalTaskController::class, 'generateIdCardBack']);
    });
    
    // QR Code Routes
    Route::prefix('qrcode')->group(function () {
        Route::get('/', [QrcodeController::class, 'index'])->name('qrcode');
        Route::get('/generatePDF', [QrcodeController::class, 'generatePDF'])->name('generatePDF');
    });
    
    // History Routes
    Route::get('/history', [HistoryController::class, 'index'])->name('history');
    
    // Outstanding Routes
    Route::get('/outstanding', [OutstandingController::class, 'index'])->name('outstanding');
    
    // Static Pages
    Route::get('/comingsoon', function () {
        $name_page = "B'Mine - Dashboard";
        return view('comingsoon.comingsoon', compact('name_page'));
    });
});
