<div id="kategori-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div onclick="closeKategoriModal()" class="fixed inset-0 bg-black/30"></div>
    <div class="relative bg-white border p-6" style="width:360px">
        <div class="flex items-center mb-4">
            <span class="flex-1">Tambah Kategori</span>
            <button onclick="closeKategoriModal()" class="text-gray-400" style="background:none;border:none">&times;</button>
        </div>
        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="text" name="nama" placeholder="Nama" class="w-full px-3 py-2 border" required>
            </div>
            <div class="mb-3">
                <input type="color" name="warna" value="#6366f1" class="border" required>
            </div>
            <button type="submit" class="w-full py-2 bg-amber-400 text-white" style="border:none">Tambah</button>
        </form>
    </div>
</div>