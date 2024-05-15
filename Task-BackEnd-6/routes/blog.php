<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('post.index');
// Route::get('/post/{id}', [PostController::class, 'show'])->name('post.show');
// Route::get('/post/{id}/edit', [PostController::class, 'edit'])->name('post.edit');
// Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
// Route::post('/post', [PostController::class, 'store'])->name('post.store');
// Route::put('/post/{id}', [PostController::class, 'update'])->name('post.update');
// Route::delete('/post/{id}', [PostController::class, 'update'])->name('post.delete');

Route::resource('post', PostController::class);