<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('todo.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/settings', function () {
    return view('settings.index');
})->middleware(['auth'])->name('settings.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('kategori', KategoriController::class)->except(['show']);
    Route::resource('tag', TagController::class)->except(['show']);
    Route::resource('todo', TodoController::class)->except(['show']);
});

require __DIR__.'/auth.php';
