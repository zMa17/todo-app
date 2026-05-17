<?php

namespace App\Providers;

use App\Models\Kategori;
use App\Models\Tag;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $view->with('kategoris', Kategori::withCount('todos')->get());
            $view->with('tags', Tag::withCount('todos')->get());
            $view->with('upcomingCount', \App\Models\Todo::where('is_completed', false)->count());
            $view->with('todayCount', \App\Models\Todo::whereDate('tanggal_deadline', today())->where('is_completed', false)->count());
            $view->with('completedCount', \App\Models\Todo::where('is_completed', true)->count());
        });
    }
}
