<!-- Modal Tambah Kategori -->
<div id="modalKategori" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/40" onclick="closeModalKategori()"></div>
    <div class="relative bg-white border border-[#e5e5e4] rounded-lg shadow-lg w-full max-w-md mx-4 p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-bold text-gray-900">Tambah Kategori</h1>
            <button onclick="closeModalKategori()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('kategori.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="kategori_nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input type="text" name="nama" id="kategori_nama" value="{{ old('nama') }}" required
                    class="w-full px-3 py-2 border border-[#e5e5e4] rounded-lg text-sm focus:ring-1 focus:ring-amber-400 focus:border-amber-400">
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="kategori_warna" class="block text-sm font-medium text-gray-700 mb-1">Warna Kategori</label>
                <input type="color" name="warna" id="kategori_warna" value="{{ old('warna', '#6366f1') }}" required
                    class="w-10 h-10 p-0.5 border border-[#e5e5e4] rounded-lg cursor-pointer">
                @error('warna')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeModalKategori()"
                    class="px-5 py-2 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-amber-400 hover:bg-amber-500 text-white font-medium text-sm rounded-lg transition-colors">
                    Tambah Kategori
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalKategori() {
        const modal = document.getElementById('modalKategori');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }
    function closeModalKategori() {
        const modal = document.getElementById('modalKategori');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeModalKategori();
    });
</script>