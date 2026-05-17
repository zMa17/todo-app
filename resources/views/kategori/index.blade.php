<x-app-layout>
    <div class="max-w-3xl mx-auto px-8 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Daftar Kategori</h1>
            <button onclick="openKategoriModal()" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-amber-400 hover:bg-amber-500 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah
            </button>
        </div>

        <div class="bg-white border border-[#e5e5e4] rounded-lg overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-[#e5e5e4] bg-gray-50">
                        <th class="text-left px-4 py-3 font-medium text-gray-500">Nama</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-500">Warna</th>
                        <th class="text-right px-4 py-3 font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategoris as $kategori)
                        <tr class="border-b border-[#e5e5e4] last:border-0 hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $kategori->nama }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full" style="background-color: {{ $kategori->warna }}"></span>
                                    <span class="text-xs text-gray-500">{{ $kategori->warna }}</span>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('kategori.edit', $kategori->id) }}" class="text-sm text-gray-500 hover:text-amber-500 mr-3">Edit</a>
                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-gray-500 hover:text-red-500">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>