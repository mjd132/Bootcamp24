<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthenticationMiddleware;
use Illuminate\Support\Facades\Route;

//second way
Route::get('login', [AuthController::class, 'loginPage'])->name('login')->middleware(AuthenticationMiddleware::class);
Route::get('register', [AuthController::class, 'registerPage'])->name('register')->middleware(AuthenticationMiddleware::class);
Route::post('login', [AuthController::class, 'login'])->name('auth.login')->middleware(AuthenticationMiddleware::class);
Route::post('register', [AuthController::class, 'register'])->name('auth.register')->middleware(AuthenticationMiddleware::class);


//first way
// Route::middleware(['guest'])->group(function () {
//     Route::get('login', [AuthController::class, 'loginPage'])->name('login');
//     Route::get('register', [AuthController::class, 'registerPage'])->name('register');
//     Route::post('login', [AuthController::class, 'login'])->name('auth.login');
//     Route::post('register', [AuthController::class, 'register'])->name('auth.register');
// });

Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware(['auth']);

