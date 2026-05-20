<x-app-layout>
    <div class="flex h-[calc(100vh-0px)]">
        <div class="flex-1 overflow-y-auto px-8 py-8">
            <div class="flex items-center mb-6">
                <h1 style="font-size:32px;font-weight:700" class="flex-1">Upcoming</h1>
                <span class="px-2 py-0.5 bg-gray-100 text-gray-400">{{ $todos->count() }}</span>
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
                                <div class="w-5 h-5 border-2 {{ $t->is_completed ? 'bg-amber-400 border-amber-400' : 'border-gray-300' }}" style="display:flex;align-items:center;justify-content:center">
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
                        <input type="text" name="judul" placeholder="Judul task" value="{{ old('judul', $todo->judul) }}" class="w-full px-3 py-2 border" required>
                        @error('judul') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-4">
                        <textarea name="deskripsi" placeholder="Deskripsi" class="w-full px-3 py-2 border" rows="3">{{ old('deskripsi', $todo->deskripsi) }}</textarea>
                        @error('deskripsi') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3 flex items-center">
                        <span class="w-24 text-gray-500">Kategori</span>
                        <select name="kategori_id" class="flex-1 px-3 py-1.5 border">
                            <option value="">-- Pilih --</option>
                            @foreach ($kategoris as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_id', $todo->kategori_id) == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3 flex items-center">
                        <span class="w-24 text-gray-500">Deadline</span>
                        <input type="date" name="tanggal_deadline" value="{{ old('tanggal_deadline', $todo->tanggal_deadline->format('Y-m-d')) }}" class="flex-1 px-3 py-1.5 border" required>
                        @error('tanggal_deadline') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <span class="text-gray-500">Tags</span>
                        <div class="mt-1">
                            @php $selectedTags = old('tags', $todo->tags->pluck('id')->toArray()) @endphp
                            @foreach ($tags as $tag)
                                <label class="inline-block mr-2 px-3 py-1 mb-1" style="background:{{ $tag->warna }}20;color:{{ $tag->warna }}">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}>
                                    {{ $tag->nama }}
                                </label>
                            @endforeach
                        </div>
                        @error('tags') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <span class="text-gray-500">Prioritas</span>
                        <div class="flex mt-1">
                            @foreach (['low'=>'Low','medium'=>'Medium','high'=>'High'] as $val=>$label)
                                <label class="mr-3 px-3 py-1 {{ old('prioritas', $todo->prioritas) == $val ? 'bg-amber-400 text-white' : 'bg-gray-100' }}">
                                    <input type="radio" name="prioritas" value="{{ $val }}" {{ old('prioritas', $todo->prioritas) == $val ? 'checked' : '' }}>
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>
                        @error('prioritas') <div class="text-red-500">{{ $message }}</div> @enderror
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-500 mr-3">Completed</span>
                        <label class="relative">
                            <input type="checkbox" name="is_completed" value="1" {{ old('is_completed', $todo->is_completed) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-9 h-5 bg-gray-200 rounded-full peer-checked:bg-amber-400" style="transition:0.2s">
                                <div class="w-4 h-4 bg-white rounded-full" style="transition:0.2s;transform:{{ old('is_completed', $todo->is_completed) ? 'translateX(16px)' : 'translateX(2px)' }};margin-top:2px"></div>
                            </div>
                        </label>
                    </div>
                </div>
            </form>
            <div class="px-5 py-4 border-t flex">
                <form action="{{ route('todo.destroy', $todo) }}" method="POST" class="flex-1 mr-2" onsubmit="return confirm('Yakin ingin menghapus todo ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-2 border text-gray-500" style="background:none">Delete Task</button>
                </form>
                <button type="submit" form="update-form" class="flex-1 py-2 bg-amber-400 text-white" style="border:none">Simpan</button>
            </div>
        </aside>
    </div>
</x-app-layout>