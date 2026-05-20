<x-app-layout>
    <div class="max-w-xl mx-auto px-8 py-8">
        <a href="{{ route('kategori.index') }}" class="text-gray-500">&larr; Kembali</a>
        <h1 style="font-size:24px;font-weight:700;margin:16px 0">Edit Kategori</h1>
        <div class="bg-white border p-6">
            <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="mb-1">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}" class="w-full px-3 py-2 border" required>
                    @error('nama') <div class="text-red-500">{{ $message }}</div> @enderror
                </div>
                <div class="mb-4">
                    <label class="mb-1">Warna</label>
                    <input type="color" name="warna" value="{{ old('warna', $kategori->warna) }}" class="border" required>
                    @error('warna') <div class="text-red-500">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="px-6 py-2 bg-amber-400 text-white" style="border:none">Update</button>
            </form>
        </div>
    </div>
</x-app-layout>