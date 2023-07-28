<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AbsensiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// This route is only accessible by users with the 'admin' role.
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class)->middleware('admin:admin');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
Route::get('dashboard', [AuthController::class, 'dashboard']);
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
// routing url untuk mengunduh data user dalam format EXCEL
Route::get('users-excel', [UserController::class, 'usersExcel']);
// Absensi
Route::get('/absensi/{nama}', [AbsensiController::class, 'index']);
Route::post('absensi/store', [AbsensiController::class, 'store']);
Route::get('/absensi/update/{id}', [AbsensiController::class, 'update'])->name('absensi.update');
