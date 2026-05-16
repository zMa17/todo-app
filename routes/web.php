<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/', [TodoController::class, 'index'])->name('dashboard');

Route::prefix('todos')->name('todos.')->group(function () {
    Route::get('/', [TodoController::class, 'index'])->name('index');
    Route::get('/create', [TodoController::class, 'create'])->name('create');
    Route::post('/', [TodoController::class, 'store'])->name('store');
    Route::get('/{todo}/edit', [TodoController::class, 'edit'])->name('edit');
    Route::put('/{todo}', [TodoController::class, 'update'])->name('update');
    Route::delete('/{todo}', [TodoController::class, 'destroy'])->name('destroy');
    Route::patch('/{todo}/toggle', [TodoController::class, 'toggle'])->name('toggle');
});
