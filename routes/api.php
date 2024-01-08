<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MahasiswaController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/mahasiswa', [MahasiswaController::class, 'destroy']);
});

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::post('/register', [HomeController::class, 'register'])->name('register');
Route::post('/login', [HomeController::class, 'login'])->name('login.api');

Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
Route::post('/mahasiswa', [MahasiswaController::class, 'store']);
Route::post('/mahasiswaaa', [MahasiswaController::class, 'update']);
