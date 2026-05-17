<x-app-layout>
    <div class="py-6">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-xl font-semibold text-[#1a1a1a] mb-6">Edit Todo</h1>

            @if ($errors->any())
                <div class="mb-4 px-4 py-3 bg-[#fde0ec] text-[#e03131] rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white border border-[#e5e3df] rounded-xl p-6">
                <form action="{{ route('todo.update', $todo) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Judul</label>
                            <input type="text" name="judul" value="{{ old('judul', $todo->judul) }}" required
                                class="w-full border border-[#c8c4be] rounded-lg px-4 py-2.5 h-11 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Deskripsi</label>
                            <textarea name="deskripsi" rows="3" required
                                class="w-full border border-[#c8c4be] rounded-lg px-4 py-2.5 text-sm">{{ old('deskripsi', $todo->deskripsi) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Tanggal Deadline</label>
                            <input type="date" name="tanggal_deadline" value="{{ old('tanggal_deadline', $todo->tanggal_deadline->format('Y-m-d')) }}" required
                                class="w-full border border-[#c8c4be] rounded-lg px-4 py-2.5 h-11 text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Kategori</label>
                            <select name="kategori_id" required
                                class="w-full border border-[#c8c4be] rounded-lg px-4 py-2.5 h-11 text-sm">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ old('kategori_id', $todo->kategori_id) == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-1">Prioritas</label>
                            <div class="flex gap-4 pt-1">
                                @foreach (['low', 'medium', 'high'] as $p)
                                    <label class="flex items-center gap-1.5 text-sm text-[#37352f]">
                                        <input type="radio" name="prioritas" value="{{ $p }}"
                                            {{ old('prioritas', $todo->prioritas) == $p ? 'checked' : '' }} required>
                                        {{ ucfirst($p) }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#37352f] mb-2">Tags</label>
                            <div class="flex flex-wrap gap-3">
                                @php $selectedTags = old('tags', $todo->tags->pluck('id')->toArray()); @endphp
                                @foreach ($tags as $t)
                                    <label class="flex items-center gap-1.5 text-sm text-[#37352f]">
                                        <input type="checkbox" name="tags[]" value="{{ $t->id }}"
                                            {{ in_array($t->id, $selectedTags) ? 'checked' : '' }}>
                                        {{ $t->nama }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="flex items-center gap-2 text-sm text-[#37352f]">
                                <input type="checkbox" name="is_completed" value="1"
                                    {{ old('is_completed', $todo->is_completed) ? 'checked' : '' }}>
                                Sudah Selesai
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 mt-6">
                        <button type="submit" class="px-5 py-2.5 bg-[#5645d4] hover:bg-[#4534b3] text-white rounded-lg text-sm font-medium">
                            Update Todo
                        </button>
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 text-sm text-[#37352f] border border-[#c8c4be] rounded-lg hover:bg-[#f6f5f4]">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
