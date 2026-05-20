<x-app-layout>
    <div class="px-8 py-8">
        <div class="flex items-center mb-6">
            <h1 class="flex-1" style="font-size:24px;font-weight:700">Kategori</h1>
            <button onclick="openKategoriModal()" class="px-4 py-2 bg-amber-400 text-white" style="border:none">+ Tambah</button>
        </div>
        <div class="bg-white border">
            <table class="w-full">
                <tr class="border-b bg-gray-50">
                    <th class="text-left px-4 py-3">Nama</th>
                    <th class="text-left px-4 py-3">Warna</th>
                    <th class="text-right px-4 py-3">Aksi</th>
                </tr>
                @foreach($kategoris as $k)
                    <tr class="border-b">
                        <td class="px-4 py-3">{{ $k->nama }}</td>
                        <td class="px-4 py-3">
                            <span class="w-4 h-4 inline-block mr-1" style="background:{{ $k->warna }};border-radius:50%;vertical-align:middle"></span>
                            <span class="text-gray-500">{{ $k->warna }}</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('kategori.edit', $k->id) }}" class="mr-3 text-gray-500">Edit</a>
                            <form action="{{ route('kategori.destroy', $k->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-500" style="background:none;border:none">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-app-layout>