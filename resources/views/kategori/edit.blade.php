<x-app-layout>
    <div class="max-w-xl mx-auto px-8 py-8">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('kategori.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7 7l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Edit Kategori</h1>
        </div>

        <div class="bg-white border border-[#e5e5e4] rounded-lg p-6">
            <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $kategori->nama) }}" required
                        class="w-full px-3 py-2 border border-[#e5e5e4] rounded-lg text-sm focus:ring-1 focus:ring-amber-400 focus:border-amber-400">
                    @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="warna" class="block text-sm font-medium text-gray-700 mb-1">Warna Kategori</label>
                    <input type="color" name="warna" id="warna" value="{{ old('warna', $kategori->warna) }}" required
                        class="w-10 h-10 p-0.5 border border-[#e5e5e4] rounded-lg cursor-pointer">
                    @error('warna')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="pt-2">
                    <button type="submit" class="px-6 py-2 bg-amber-400 hover:bg-amber-500 text-white font-medium text-sm rounded-lg transition-colors">
                        Update Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>