<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TodoController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('kategori', KategoriController::class)->except(['show']);
Route::resource('tag', TagController::class)->except(['show']);
Route::resource('todo', TodoController::class)->except(['show']);