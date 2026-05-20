<div id="tag-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div onclick="closeTagModal()" class="fixed inset-0 bg-black/30"></div>
    <div class="relative bg-white border p-6 rounded-lg" style="width:360px">
        <div class="flex items-center mb-4">
            <span class="flex-1">Tambah Tag</span>
            <button onclick="closeTagModal()" class="text-gray-400" style="background:none;border:none">&times;</button>
        </div>
        <form action="{{ route('tag.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="text" name="nama" placeholder="Nama" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div class="mb-3">
                <input type="color" name="warna" value="#f59e0b" class="border rounded-lg" required>
            </div>
            <button type="submit" class="w-full py-2 bg-amber-400 text-white rounded-lg" style="border:none">Simpan</button>
        </form>
    </div>
</div>