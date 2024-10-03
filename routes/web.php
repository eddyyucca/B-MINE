<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RequestController;

// dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
<<<<<<< HEAD
=======
Route::get('/dashboard_external', [DashboardController::class, 'dashboard_external'])->name('dashboard_external');
>>>>>>> 1aaaf7a (update 03102024)
Route::get('/about', [DashboardController::class, 'about'])->name('about');

// Auth
Route::get('/login', [AuthController::class,'login'])->name('login');

// request
Route::get('/request', [RequestController::class,'index']);
Route::get('/not_found', [RequestController::class,'not_found']);

Route::get('/search_nik', function () {  return redirect('/not_found'); })->name('search_nik');
Route::post('/search_nik', [RequestController::class, 'get_data_nik'])->name('search_nik.post');

// comingsoon
Route::get('/comingsoon', function () {
    return view('comingsoon.comingsoon');
});