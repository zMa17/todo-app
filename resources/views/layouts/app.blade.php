<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f7f7f5]" style="font-family:'Inter',system-ui,sans-serif;margin:0">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-white border-r min-h-screen flex flex-col">
            <div class="px-4 py-3 border-b">
                <span class="text-gray-800">Menu</span>
            </div>
            <div class="flex-1 px-3 pt-4" id="sidebar-menu">
                <div class="mb-5">
                    <p class="text-gray-400 px-2 mb-1">Tasks</p>
                    <a href="{{ route('todo.index') }}" onclick="return window.loadTodos ? (loadTodos(this.href), false) : true" class="flex px-3 py-2 rounded-lg {{ !request('filter') && !request('kategori') && !request('tag') ? 'bg-gray-100' : '' }}">Upcoming</a>
                    <a href="{{ route('todo.index', ['filter' => 'today']) }}" onclick="return window.loadTodos ? (loadTodos(this.href), false) : true" class="flex px-3 py-2 rounded-lg {{ request('filter') === 'today' ? 'bg-gray-100' : '' }}">Today</a>
                    <a href="{{ route('todo.index', ['filter' => 'completed']) }}" onclick="return window.loadTodos ? (loadTodos(this.href), false) : true" class="flex px-3 py-2 rounded-lg {{ request('filter') === 'completed' ? 'bg-gray-100' : '' }}">Completed</a>
                </div>
                <div class="mb-5">
                    <p class="text-gray-400 px-2 mb-1">Kategori</p>
                    @foreach ($kategoris as $kategori)
                        @if ($kategori->todos_count > 0)
                            <a href="{{ route('todo.index', ['kategori' => $kategori->id]) }}" onclick="return window.loadTodos ? (loadTodos(this.href), false) : true" class="flex px-3 py-2 rounded-lg {{ request('kategori') == $kategori->id ? 'bg-gray-100' : '' }}">
                                <span class="w-2.5 h-2.5 inline-block mr-2" style="background:{{ $kategori->warna }};border-radius:50%"></span>
                                {{ $kategori->nama }}
                            </a>
                        @endif
                    @endforeach
                    <button onclick="openKategoriModal()" class="flex px-3 py-2 text-gray-400 w-full rounded-lg">+ Tambah Kategori Baru</button>
                </div>
                <div class="mb-5">
                    <p class="text-gray-400 px-2 mb-1">Tags</p>
                    <div class="px-2">
                        @foreach ($tags as $tag)
                            <a href="{{ route('todo.index', ['tag' => $tag->id]) }}" onclick="return window.loadTodos ? (loadTodos(this.href), false) : true" class="inline-block px-2 py-0.5 mr-1 mb-1 text-xs rounded-lg" style="background:{{ $tag->warna }}20;color:{{ $tag->warna }}">
                                {{ $tag->nama }}
                            </a>
                        @endforeach
                        <button onclick="openTagModal()" class="inline-block px-2 py-0.5 text-xs text-gray-400 border border-dashed rounded-lg">+ Add Tag</button>
                    </div>
                </div>
            </div>
            <div class="px-3 py-2 border-t">
                <a href="{{ route('settings.index') }}" class="flex px-3 py-2 rounded-lg text-gray-600">Settings</a>
            </div>
            <div class="px-3 py-2 border-t">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex px-3 py-2 text-gray-500 w-full rounded-lg">Log out</button>
                </form>
            </div>
        </aside>
        <main class="flex-1 min-h-screen">
            {{ $slot }}
        </main>
    </div>

    @include('components.modal-kategori')
    @include('components.modal-tag')

    <script>
        function openKategoriModal() { document.getElementById('kategori-modal').classList.remove('hidden') }
        function closeKategoriModal() { document.getElementById('kategori-modal').classList.add('hidden') }
        function openTagModal() { document.getElementById('tag-modal').classList.remove('hidden') }
        function closeTagModal() { document.getElementById('tag-modal').classList.add('hidden') }
    </script>
</body>
</html>