<x-app-layout>
    @php
        $selectedTagIds = old('tags', $todo->tags->pluck('id')->toArray());
    @endphp
    <div class="flex h-[calc(100vh-0px)]" x-data="{
        selectedTags: {{ json_encode($selectedTagIds) }},
        prioritas: '{{ old('prioritas', $todo->prioritas) }}',
        completed: {{ old('is_completed', $todo->is_completed) ? 'true' : 'false' }}
    }">
        <div class="flex-1 overflow-y-auto px-8 py-8">
            <div class="flex items-center mb-6">
                <h1 style="font-size:32px;font-weight:700" class="flex-1">Upcoming</h1>
                <span class="px-2 py-0.5 bg-gray-100 rounded-lg text-gray-400">{{ $todos->count() }}</span>
            </div>
            @foreach ($todos as $t)
                <div class="flex px-4 py-3 border-b {{ $t->id === $todo->id ? 'bg-amber-50' : '' }}">
                    <div class="mr-3">
                        <form action="{{ route('todo.update', $t) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="judul" value="{{ $t->judul }}">
                            <input type="hidden" name="deskripsi" value="{{ $t->deskripsi }}">
                            <input type="hidden" name="tanggal_deadline" value="{{ $t->tanggal_deadline->format('Y-m-d') }}">
                            <input type="hidden" name="prioritas" value="{{ $t->prioritas }}">
                            <input type="hidden" name="kategori_id" value="{{ $t->kategori_id }}">
                            @foreach ($t->tags as $tag)
                                <input type="hidden" name="tags[]" value="{{ $tag->id }}">
                            @endforeach
                            <button type="submit" name="is_completed" value="{{ $t->is_completed ? '0' : '1' }}" style="background:none;border:none;padding:0">
                                <div class="w-5 h-5 border-2 {{ $t->is_completed ? 'bg-amber-400 border-amber-400' : 'border-gray-300' }} rounded" style="display:flex;align-items:center;justify-content:center">
                                    @if ($t->is_completed) &#10003; @endif
                                </div>
                            </button>
                        </form>
                    </div>
                    <div class="flex-1">
                        <div class="{{ $t->is_completed ? 'text-gray-400' : '' }}" style="{{ $t->is_completed ? 'text-decoration:line-through' : '' }}">{{ $t->judul }}</div>
                    </div>
                    <a href="{{ route('todo.edit', $t) }}" class="text-gray-300" style="text-decoration:none">></a>
                </div>
            @endforeach
        </div>

        <aside class="w-80 border-l bg-white flex flex-col">
            <div class="flex items-center px-5 py-4 border-b">
                <span class="flex-1">Edit Todo</span>
                <a href="{{ route('todo.index') }}" class="text-gray-400" style="text-decoration:none">&times;</a>
            </div>
            <form id="update-form" action="{{ route('todo.update', $todo) }}" method="POST" class="flex flex-col flex-1">
                @csrf @method('PUT')
                <div class="flex-1 px-5 py-4">
                    <div class="mb-4">
                        <input type="text" name="judul" placeholder="Judul task" value="{{ old('judul', $todo->judul) }}" class="w-full px-3 py-2 border rounded-lg" required>
                        @error('judul') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <textarea name="deskripsi" placeholder="Deskripsi" class="w-full px-3 py-2 border rounded-lg" rows="3">{{ old('deskripsi', $todo->deskripsi) }}</textarea>
                        @error('deskripsi') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3 flex items-center">
                        <span class="w-24 text-gray-500">Kategori</span>
                        <select name="kategori_id" class="flex-1 px-3 py-1.5 border rounded-lg">
                            <option value="">-- Pilih --</option>
                            @foreach ($kategoris as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_id', $todo->kategori_id) == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>
                    <button type="button" onclick="openKategoriModal()" class="text-sm text-amber-500 mb-3" style="background:none;border:none;cursor:pointer">+ Tambah Kategori</button>

                    <div class="mb-3 flex items-center">
                        <span class="w-24 text-gray-500">Deadline</span>
                        <input type="date" name="tanggal_deadline" value="{{ old('tanggal_deadline', $todo->tanggal_deadline->format('Y-m-d')) }}" class="flex-1 px-3 py-1.5 border rounded-lg" required>
                        @error('tanggal_deadline') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <span class="text-gray-500">Tags</span>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach ($tags as $tag)
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    :checked="selectedTags.includes({{ $tag->id }})"
                                    class="hidden">
                                <span @click="selectedTags.includes({{ $tag->id }}) ? selectedTags = selectedTags.filter(t => t !== {{ $tag->id }}) : selectedTags.push({{ $tag->id }})"
                                    :class="selectedTags.includes({{ $tag->id }}) ? 'bg-amber-400 text-white' : ''"
                                    class="px-3 py-1 rounded-lg text-sm cursor-pointer"
                                    style="background:{{ $tag->warna }}20;color:{{ $tag->warna }}">
                                    {{ $tag->nama }}
                                </span>
                            @endforeach
                        </div>
                        @error('tags') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>
                    <button type="button" onclick="openTagModal()" class="text-sm text-amber-500 mb-3" style="background:none;border:none;cursor:pointer">+ Tambah Tag</button>

                    <div class="mb-3">
                        <span class="text-gray-500">Prioritas</span>
                        <div class="flex gap-2 mt-1">
                            @foreach (['low' => ['Low', 'bg-green-500'], 'medium' => ['Medium', 'bg-amber-400'], 'high' => ['High', 'bg-red-500']] as $val => [$label, $color])
                                <span @click="prioritas = '{{ $val }}'"
                                    :class="prioritas === '{{ $val }}' ? '{{ $color }} text-white' : 'bg-gray-100 text-gray-600'"
                                    class="flex-1 text-center px-3 py-1.5 rounded-lg text-sm cursor-pointer">
                                    {{ $label }}
                                </span>
                            @endforeach
                            <input type="hidden" name="prioritas" x-model="prioritas">
                        </div>
                        @error('prioritas') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>

                    <div class="flex items-center">
                        <span class="text-gray-500 mr-3">Completed</span>
                        <label class="relative cursor-pointer">
                            <input type="checkbox" name="is_completed" value="1" class="sr-only" x-model="completed">
                            <div :class="completed ? 'bg-amber-400' : 'bg-gray-200'"
                                class="w-9 h-5 rounded-full" style="transition:background 0.2s">
                                <div :style="'transform:translateX(' + (completed ? 16 : 2) + 'px)'"
                                    class="w-4 h-4 bg-white rounded-full" style="transition:transform 0.2s;margin-top:2px"></div>
                            </div>
                        </label>
                    </div>
                </div>
            </form>
            <div class="px-5 py-4 border-t flex">
                <form action="{{ route('todo.destroy', $todo) }}" method="POST" class="flex-1 mr-2" onsubmit="return confirm('Yakin ingin menghapus todo ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-2 border text-gray-500 rounded-lg" style="background:none">Delete Task</button>
                </form>
                <button type="submit" form="update-form" class="flex-1 py-2 bg-amber-400 text-white rounded-lg" style="border:none">Simpan</button>
            </div>
        </aside>
    </div>
</x-app-layout>