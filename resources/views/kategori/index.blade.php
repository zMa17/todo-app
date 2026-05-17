<x-app-layout>
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-xl font-semibold text-[#1a1a1a]">Daftar Kategori</h1>
                <a href="{{ route('kategori.create') }}" class="px-4 py-2 bg-[#5645d4] hover:bg-[#4534b3] text-white rounded-lg text-sm font-medium">
                    + Tambah Kategori
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 px-4 py-3 bg-[#d9f3e1] text-[#1aae39] rounded-lg text-sm">{{ session('success') }}</div>
            @endif

            <div class="bg-white border border-[#e5e3df] rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-[#f6f5f4] text-[#787671] text-left">
                            <th class="px-5 py-3 font-medium">Nama</th>
                            <th class="px-5 py-3 font-medium">Warna</th>
                            <th class="px-5 py-3 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e5e3df]">
                        @foreach($kategoris as $kategori)
                            <tr class="hover:bg-[#fafaf9]">
                                <td class="px-5 py-3 text-[#1a1a1a]">{{ $kategori->nama }}</td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center gap-2 text-sm">
                                        <span class="w-4 h-4 rounded-full border border-[#e5e3df]" style="background-color: {{ $kategori->warna }}"></span>
                                        {{ $kategori->warna }}
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('kategori.edit', $kategori->id) }}" class="text-sm text-[#5645d4] hover:underline">Edit</a>
                                        <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-[#e03131] hover:underline">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($kategoris->isEmpty())
                    <p class="px-5 py-8 text-center text-[#787671]">Belum ada kategori.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
