<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ session('theme', 'dark') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Todo App</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen flex flex-col">
    <nav class="border-b border-[#19140035] dark:border-[#3E3E3A] px-6 py-4">
        <div class="max-w-5xl mx-auto flex items-center justify-between">
            <a href="{{ route('todos.index') }}" class="text-lg font-semibold tracking-tight">
                📋 Todo App
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('todos.create') }}"
                   class="inline-block px-5 py-1.5 dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] hover:bg-black hover:border-black bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal">
                    + Tambah Todo
                </a>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-5xl mx-auto w-full px-6 py-8">
        @if (session('success'))
            <div class="mb-6 p-4 bg-[#ecfdf5] dark:bg-[#065f4626] border border-[#10b981] dark:border-[#10b98166] rounded-sm text-sm text-[#065f46] dark:text-[#6ee7b7]">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
