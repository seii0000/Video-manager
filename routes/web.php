<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Trang chủ
Route::get('/', function () {
    return view('welcome');
});

// Xác thực
Auth::routes();

// Chuyển hướng sau khi đăng nhập
Route::get('/home', function () {
    return redirect()->route('dashboard');
})->name('home');

// Dashboard (hiển thị danh sách video của user đã đăng nhập)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Routes cho quản lý video (cần authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
    Route::get('/videos/create', [VideoController::class, 'create'])->name('videos.create');
    Route::post('/videos', [VideoController::class, 'store'])->name('videos.store');
    Route::get('/videos/{video}', [VideoController::class, 'show'])->name('videos.show');
    Route::get('/videos/{video}/edit', [VideoController::class, 'edit'])->name('videos.edit');
    Route::put('/videos/{video}', [VideoController::class, 'update'])->name('videos.update');
    Route::delete('/videos/{video}', [VideoController::class, 'destroy'])->name('videos.destroy');
});

// Routes cho quản lý người dùng (giữ nguyên)
Route::get('/admin', [UserController::class, 'index'])->name('user.index');

Route::group(['prefix' => 'admin/user'], function () {
    Route::get('/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/add', [UserController::class, 'store'])->name('user.store');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::post('/delete', [UserController::class, 'destroy'])->name('user.delete');
});