<x-app-layout>
    <div class="py-6">
        <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-xl font-semibold text-[#1a1a1a] mb-6">Edit Tag</h1>

            <div class="bg-white border border-[#e5e3df] rounded-xl p-6">
                <form action="{{ route('tag.update', $tag->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label for="nama" class="block text-sm font-medium text-[#37352f] mb-1">Nama Tag</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $tag->nama) }}" required
                                class="w-full border border-[#c8c4be] rounded-lg px-4 py-2.5 h-11 text-sm">
                        </div>
                        <div>
                            <label for="warna" class="block text-sm font-medium text-[#37352f] mb-1">Warna Tag</label>
                            <input type="color" name="warna" id="warna" value="{{ old('warna', $tag->warna) }}" required
                                class="w-full h-11 rounded-lg border border-[#c8c4be] px-1">
                        </div>
                    </div>
                    <div class="flex items-center gap-3 mt-6">
                        <button type="submit" class="px-5 py-2.5 bg-[#5645d4] hover:bg-[#4534b3] text-white rounded-lg text-sm font-medium">
                            Update
                        </button>
                        <a href="{{ route('tag.index') }}" class="px-5 py-2.5 text-sm text-[#37352f] border border-[#c8c4be] rounded-lg hover:bg-[#f6f5f4]">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
