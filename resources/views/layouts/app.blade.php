<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#f7f7f5]" style="font-family: 'Inter', system-ui, sans-serif;">
    <button id="sidebar-toggle" onclick="toggleSidebar()" class="fixed top-4 left-4 z-50 p-2 rounded-lg hover:bg-gray-200 text-gray-500 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-black/20 z-20 hidden transition-opacity"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-[#e5e5e4] flex flex-col transition-transform duration-200 -translate-x-full">
        <div class="flex items-center justify-between px-4 h-14 border-b border-[#e5e5e4]">
            <span class="text-sm font-semibold text-gray-800">Menu</span>
        </div>

        <div class="px-4 pt-3">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" placeholder="Search" class="w-full pl-9 pr-3 py-1.5 text-sm bg-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 border-0">
            </div>
        </div>

        <div class="flex-1 overflow-y-auto px-3 pt-4 space-y-5">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-2 mb-1">Tasks</p>
                <a href="{{ route('todo.index') }}" class="flex items-center justify-between px-2 py-1.5 text-sm rounded-lg hover:bg-gray-100 {{ !request('filter') && !request('kategori') && !request('tag') ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-600' }}">
                    <span>Upcoming</span>
                    <span class="text-xs text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded-full">{{ $upcomingCount }}</span>
                </a>
                <a href="{{ route('todo.index', ['filter' => 'today']) }}" class="flex items-center justify-between px-2 py-1.5 text-sm rounded-lg hover:bg-gray-100 {{ request('filter') === 'today' ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-600' }}">
                    <span>Today</span>
                    <span class="text-xs text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded-full">{{ $todayCount }}</span>
                </a>
                <a href="{{ route('todo.index', ['filter' => 'completed']) }}" class="flex items-center justify-between px-2 py-1.5 text-sm rounded-lg hover:bg-gray-100 {{ request('filter') === 'completed' ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-600' }}">
                    <span>Completed</span>
                    <span class="text-xs text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded-full">{{ $completedCount }}</span>
                </a>
            </div>

            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-2 mb-1">Kategori</p>
                <div class="space-y-0.5">
                    @foreach ($kategoris as $kategori)
                        <a href="{{ route('todo.index', ['kategori' => $kategori->id]) }}" class="flex items-center justify-between px-2 py-1.5 text-sm rounded-lg hover:bg-gray-100 {{ request('kategori') == $kategori->id ? 'bg-gray-100 font-semibold text-gray-900' : 'text-gray-600' }}">
                            <span class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $kategori->warna }}"></span>
                                {{ $kategori->nama }}
                            </span>
                            <span class="text-xs text-gray-400">{{ $kategori->todos_count }}</span>
                        </a>
                    @endforeach
                    <button onclick="openModalKategori()" class="flex items-center gap-2 px-2 py-1.5 text-sm text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 w-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Kategori Baru
                    </button>
                </div>
            </div>

            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-2 mb-1">Tags</p>
                <div class="flex flex-wrap gap-1.5 px-2">
                    @foreach ($tags as $tag)
                        <a href="{{ route('todo.index', ['tag' => $tag->id]) }}" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium hover:opacity-80" style="background-color: {{ $tag->warna }}20; color: {{ $tag->warna }} {{ request('tag') == $tag->id ? 'ring-2 ring-offset-1' : '' }}">
                            {{ $tag->nama }}
                        </a>
                    @endforeach
                    <button onclick="openModalTag()" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium text-gray-400 border border-dashed border-gray-300 hover:text-gray-600 hover:border-gray-400">
                        + Add Tag
                    </button>
                </div>
            </div>

            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-2 mb-1">Settings</p>
                <a href="{{ route('kategori.index') }}" class="flex items-center gap-2 px-2 py-1.5 text-sm rounded-lg hover:bg-gray-100 text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Kategori
                </a>
                <a href="{{ route('tag.index') }}" class="flex items-center gap-2 px-2 py-1.5 text-sm rounded-lg hover:bg-gray-100 text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Tag
                </a>
            </div>
        </div>

        <div class="px-3 py-3 border-t border-[#e5e5e4]">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-2 py-1.5 text-sm text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 w-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Log out
                </button>
            </form>
        </div>
    </aside>

    <div id="main-content" class="flex-1 min-h-screen">
        {{ $slot }}
    </div>

    @include('components.modal-kategori')
    @include('components.modal-tag')

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        function openKategoriModal() {
            document.getElementById('kategori-modal').classList.remove('hidden');
        }

        function closeKategoriModal() {
            document.getElementById('kategori-modal').classList.add('hidden');
        }

        function openTagModal() {
            document.getElementById('tag-modal').classList.remove('hidden');
        }

        function closeTagModal() {
            document.getElementById('tag-modal').classList.add('hidden');
        }
    </script>
</body>
</html>