<x-app-layout>
    <div class="px-8 py-8">
        <h1 style="font-size:24px;font-weight:700;margin-bottom:24px">Settings</h1>
        <div class="flex gap-4">
            <a href="{{ route('kategori.index') }}" class="flex-1 bg-white border p-6 rounded-lg" style="text-decoration:none;color:inherit">
                <h2 style="font-size:18px;font-weight:600;margin-bottom:8px">Kategori</h2>
                <p class="text-gray-500">Kelola kategori todo</p>
            </a>
            <a href="{{ route('tag.index') }}" class="flex-1 bg-white border p-6 rounded-lg" style="text-decoration:none;color:inherit">
                <h2 style="font-size:18px;font-weight:600;margin-bottom:8px">Tag</h2>
                <p class="text-gray-500">Kelola tag todo</p>
            </a>
        </div>
    </div>
</x-app-layout>