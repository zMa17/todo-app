<div id="tag-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div onclick="closeTagModal()" class="absolute inset-0 bg-black/30"></div>
    <div class="relative bg-white rounded-lg shadow-lg p-6 w-96 border border-[#e5e5e4]">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-gray-800">Tambah Tag</h3>
            <button onclick="closeTagModal()" class="text-gray-400 hover:text-gray-600 p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('tag.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="modal-tag-nama" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama</label>
                <input type="text" name="nama" id="modal-tag-nama" required
                    class="w-full px-3 py-2 border border-[#e5e5e4] rounded-lg text-sm focus:ring-1 focus:ring-amber-400 focus:border-amber-400">
            </div>
            <div>
                <label for="modal-tag-warna" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Warna</label>
                <input type="color" name="warna" id="modal-tag-warna" value="#f59e0b" required
                    class="w-10 h-10 p-0.5 border border-[#e5e5e4] rounded-lg cursor-pointer">
            </div>
            <div class="pt-2">
                <button type="submit" class="w-full px-4 py-2 bg-amber-400 hover:bg-amber-500 text-white font-medium text-sm rounded-lg transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>